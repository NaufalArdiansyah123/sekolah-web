@extends('layouts.admin')

@section('title', 'Kalender Akademik')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900">
    <div class="container mx-auto px-6 py-8">
        <!-- Error Messages -->
        @if(isset($table_missing) && $table_missing)
        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border border-yellow-200 dark:border-yellow-800 rounded-2xl p-6 mb-8 shadow-lg">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-yellow-400 to-amber-500 p-4 rounded-xl mr-4 shadow-lg">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100 mb-2">Database Belum Siap</h3>
                    <p class="text-yellow-700 dark:text-yellow-300 mb-4">Tabel kalender belum dibuat. Silakan jalankan migration terlebih dahulu:</p>
                    <div class="bg-yellow-100 dark:bg-yellow-900/50 rounded-lg p-4 border border-yellow-200 dark:border-yellow-700">
                        <code class="text-yellow-800 dark:text-yellow-200 text-sm font-mono">php artisan migrate</code>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(isset($error))
        <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6 mb-8 shadow-lg">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-red-500 to-rose-600 p-4 rounded-xl mr-4 shadow-lg">
                    <i class="fas fa-exclamation-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-red-900 dark:text-red-100 mb-2">Terjadi Kesalahan</h3>
                    <p class="text-red-700 dark:text-red-300 mb-2">{{ $error }}</p>
                    <p class="text-red-600 dark:text-red-400 text-sm">Silakan periksa log Laravel untuk detail lebih lanjut.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Enhanced Page Header -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 px-8 py-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-6 lg:mb-0">
                        <div class="flex items-center mb-4">
                            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl mr-4 shadow-lg">
                                <i class="fas fa-calendar-alt text-white text-3xl"></i>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold text-white mb-2">Kalender Akademik</h1>
                                <p class="text-blue-100 text-lg">Kelola jadwal dan acara sekolah dengan sinkronisasi agenda otomatis</p>
                            </div>
                        </div>
                        
                        <!-- Quick Stats in Header -->
                        @if(isset($stats))
                        <div class="flex flex-wrap gap-4 mt-4">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                <div class="text-white/80 text-sm">Total Events</div>
                                <div class="text-white text-xl font-bold">{{ $stats['total_events'] ?? 0 }}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                <div class="text-white/80 text-sm">Akan Datang</div>
                                <div class="text-white text-xl font-bold">{{ $stats['upcoming_events'] ?? 0 }}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                <div class="text-white/80 text-sm">Bulan Ini</div>
                                <div class="text-white text-xl font-bold">{{ $stats['this_month_events'] ?? 0 }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="button" onclick="syncFromAgenda()" 
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 border border-white/20">
                            <i class="fas fa-sync mr-3 group-hover:rotate-180 transition-transform duration-500"></i>
                            <span class="font-semibold">Sync Agenda</span>
                        </button>
                        <button type="button" onclick="showAddEventModal()" 
                                class="group bg-white hover:bg-gray-50 text-blue-600 px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold">
                            <i class="fas fa-plus mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Tambah Event</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Statistics Cards -->
        @if(isset($stats))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-calendar-check text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="text-right">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Events</h3>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_events'] ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Semua event</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="text-right">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Akan Datang</h3>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['upcoming_events'] ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Event mendatang</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="bg-gradient-to-r from-yellow-500 to-amber-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-history text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="text-right">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Selesai</h3>
                        <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['past_events'] ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Event selesai</p>
                    </div>
                </div>
            </div>

            <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-calendar-day text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="text-right">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Bulan Ini</h3>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['this_month_events'] ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Event bulan ini</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Enhanced Calendar Container -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Calendar Header -->
            <div class="bg-gradient-to-r from-slate-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-8 py-6 border-b border-gray-200 dark:border-gray-600">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-4 lg:mb-0">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-calendar-week text-blue-600 mr-3"></i>
                            Kalender Interaktif
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Klik pada event untuk melihat detail atau mengedit</p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-4">
                        <button id="today-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-medium">
                            <i class="fas fa-calendar-day mr-2"></i>Hari Ini
                        </button>
                        
                        <!-- Legend -->
                        <div class="flex flex-wrap items-center gap-3 text-sm">
                            <div class="flex items-center bg-white dark:bg-gray-700 px-3 py-2 rounded-lg shadow-md">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2 shadow-sm"></div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Event</span>
                            </div>
                            <div class="flex items-center bg-white dark:bg-gray-700 px-3 py-2 rounded-lg shadow-md">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2 shadow-sm"></div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Agenda</span>
                            </div>
                            <div class="flex items-center bg-white dark:bg-gray-700 px-3 py-2 rounded-lg shadow-md">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2 shadow-sm"></div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Holiday</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Body -->
            <div class="p-8">
                <div id="calendar" class="min-h-[700px] rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-center h-96">
                        <div class="text-center">
                            <div class="relative">
                                <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-200 border-t-blue-600 mx-auto mb-6"></div>
                                <div class="absolute inset-0 rounded-full bg-blue-100 opacity-20 animate-pulse"></div>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">Memuat Kalender</h3>
                            <p class="text-gray-500 dark:text-gray-400">Sedang mengambil data events...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Panel -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Events -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-clock text-blue-600 mr-3"></i>
                        Event Terbaru
                    </h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">5 event terakhir</span>
                </div>
                <div id="recent-events" class="space-y-3">
                    <div class="animate-pulse">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                            <div class="flex-1">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-2"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-1/2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                    Quick Actions
                </h3>
                <div class="space-y-4">
                    <button onclick="showAddEventModal()" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                        <i class="fas fa-plus mr-3"></i>
                        <span class="font-semibold">Tambah Event Baru</span>
                    </button>
                    
                    <button onclick="syncFromAgenda()" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                        <i class="fas fa-sync mr-3"></i>
                        <span class="font-semibold">Sinkronisasi Agenda</span>
                    </button>
                    
                    <a href="{{ route('academic.calendar') }}" target="_blank" class="w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                        <i class="fas fa-external-link-alt mr-3"></i>
                        <span class="font-semibold">Lihat Kalender Public</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Add Event Modal -->
<div id="addEventModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 px-8 py-6 rounded-t-3xl">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-white">Tambah Event Baru</h3>
                    <p class="text-blue-100 mt-1">Buat event atau agenda baru untuk kalender akademik</p>
                </div>
                <button onclick="closeModal()" class="text-white hover:text-gray-200 transition-colors p-2 hover:bg-white/10 rounded-xl">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>
        <form id="addEventForm" class="p-8">
            <div class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Judul Event</label>
                        <input type="text" name="title" required
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 text-lg"
                               placeholder="Masukkan judul event...">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tipe Event</label>
                        <select name="type" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="event">🎯 Event Umum</option>
                            <option value="agenda">📋 Agenda (akan ditambahkan ke halaman agenda)</option>
                            <option value="meeting">🤝 Rapat</option>
                            <option value="holiday">🏖️ Libur</option>
                            <option value="exam">📝 Ujian</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Warna Event</label>
                        <div class="flex space-x-3">
                            <button type="button" class="color-btn w-10 h-10 rounded-xl bg-blue-500 ring-4 ring-blue-200 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#3b82f6"></button>
                            <button type="button" class="color-btn w-10 h-10 rounded-xl bg-green-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#10b981"></button>
                            <button type="button" class="color-btn w-10 h-10 rounded-xl bg-red-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#ef4444"></button>
                            <button type="button" class="color-btn w-10 h-10 rounded-xl bg-yellow-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#f59e0b"></button>
                            <button type="button" class="color-btn w-10 h-10 rounded-xl bg-purple-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#8b5cf6"></button>
                            <button type="button" class="color-btn w-10 h-10 rounded-xl bg-pink-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#ec4899"></button>
                        </div>
                        <input type="hidden" name="color" value="#3b82f6">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal Mulai</label>
                        <input type="date" name="start_date" required
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal Selesai</label>
                        <input type="date" name="end_date"
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                </div>
                
                <!-- Time Fields -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu Mulai</label>
                        <input type="time" name="start_time" id="start_time"
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang hari</small>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu Selesai</label>
                        <input type="time" name="end_time" id="end_time"
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang hari</small>
                    </div>
                </div>
                
                <!-- All Day Checkbox -->
                <div class="flex items-center bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                    <input type="checkbox" id="is_all_day" name="is_all_day" value="1"
                           class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_all_day" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-clock mr-2"></i>Acara sepanjang hari
                    </label>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Lokasi</label>
                    <input type="text" name="location"
                           class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                           placeholder="Masukkan lokasi event...">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none"
                              placeholder="Masukkan deskripsi event..."></textarea>
                </div>
            </div>
            
            <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                <button type="button" onclick="closeModal()" 
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <i class="fas fa-save mr-2"></i>Simpan Event
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Edit Event Modal -->
<div id="editEventModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-8 py-6 rounded-t-3xl">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-white">Edit Event</h3>
                    <p class="text-green-100 mt-1">Perbarui informasi event atau agenda</p>
                </div>
                <button onclick="closeEditModal()" class="text-white hover:text-gray-200 transition-colors p-2 hover:bg-white/10 rounded-xl">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>
        <form id="editEventForm" class="p-8">
            <input type="hidden" name="event_id">
            <div class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Judul Event</label>
                        <input type="text" name="title" required
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 text-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tipe Event</label>
                        <select name="type" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="event">🎯 Event Umum</option>
                            <option value="agenda">📋 Agenda (akan ditambahkan ke halaman agenda)</option>
                            <option value="meeting">🤝 Rapat</option>
                            <option value="holiday">🏖️ Libur</option>
                            <option value="exam">📝 Ujian</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Warna Event</label>
                        <div class="flex space-x-3">
                            <button type="button" class="edit-color-btn w-10 h-10 rounded-xl bg-blue-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#3b82f6"></button>
                            <button type="button" class="edit-color-btn w-10 h-10 rounded-xl bg-green-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#10b981"></button>
                            <button type="button" class="edit-color-btn w-10 h-10 rounded-xl bg-red-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#ef4444"></button>
                            <button type="button" class="edit-color-btn w-10 h-10 rounded-xl bg-yellow-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#f59e0b"></button>
                            <button type="button" class="edit-color-btn w-10 h-10 rounded-xl bg-purple-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#8b5cf6"></button>
                            <button type="button" class="edit-color-btn w-10 h-10 rounded-xl bg-pink-500 shadow-lg hover:scale-110 transition-transform duration-200" data-color="#ec4899"></button>
                        </div>
                        <input type="hidden" name="color" value="#3b82f6">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal Mulai</label>
                        <input type="date" name="start_date" required
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal Selesai</label>
                        <input type="date" name="end_date"
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                </div>
                
                <!-- Time Fields -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu Mulai</label>
                        <input type="time" name="start_time" id="edit_start_time"
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang hari</small>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu Selesai</label>
                        <input type="time" name="end_time" id="edit_end_time"
                               class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang hari</small>
                    </div>
                </div>
                
                <!-- All Day Checkbox -->
                <div class="flex items-center bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                    <input type="checkbox" id="edit_is_all_day" name="is_all_day" value="1"
                           class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="edit_is_all_day" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-clock mr-2"></i>Acara sepanjang hari
                    </label>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Lokasi</label>
                    <input type="text" name="location"
                           class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none"></textarea>
                </div>
            </div>
            
            <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                <button type="button" onclick="deleteEvent()" 
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
                <button type="button" onclick="closeEditModal()" 
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <i class="fas fa-save mr-2"></i>Update Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
let calendar;
let currentEventId = null;

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    // Check if there are errors or table missing
    @if(isset($table_missing) && $table_missing)
        calendarEl.innerHTML = '<div class="text-center py-20"><div class="bg-yellow-100 dark:bg-yellow-900 p-8 rounded-2xl w-32 h-32 mx-auto mb-6 flex items-center justify-center shadow-lg"><i class="fas fa-database text-yellow-600 dark:text-yellow-400 text-4xl"></i></div><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Database Belum Siap</h3><p class="text-gray-500 dark:text-gray-400 text-lg">Silakan jalankan migration untuk membuat tabel kalender</p></div>';
        return;
    @endif
    
    @if(isset($error))
        calendarEl.innerHTML = '<div class="text-center py-20"><div class="bg-red-100 dark:bg-red-900 p-8 rounded-2xl w-32 h-32 mx-auto mb-6 flex items-center justify-center shadow-lg"><i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-4xl"></i></div><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Terjadi Kesalahan</h3><p class="text-gray-500 dark:text-gray-400 text-lg">{{ $error }}</p></div>';
        return;
    @endif
    
    try {
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: false,
            height: 'auto',
            events: {
                url: '{{ route("admin.calendar.events") }}',
                failure: function() {
                    console.error('Failed to load calendar events');
                    showMessage('error', 'Gagal memuat events kalender');
                }
            },
            eventClick: function(info) {
                const eventId = info.event.extendedProps.event_id;
                showEditEventModal(eventId);
            },
            loading: function(bool) {
                if (bool) {
                    calendarEl.style.opacity = '0.5';
                } else {
                    calendarEl.style.opacity = '1';
                }
            },
            eventDidMount: function(info) {
                // Add tooltip and enhanced styling
                info.el.title = info.event.extendedProps.description || info.event.title;
                info.el.style.borderRadius = '8px';
                info.el.style.border = 'none';
                info.el.style.padding = '4px 8px';
                info.el.style.fontSize = '0.875rem';
                info.el.style.fontWeight = '600';
                info.el.style.cursor = 'pointer';
                info.el.style.transition = 'all 0.2s ease';
                
                // Add hover effect
                info.el.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                    this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
                });
                
                info.el.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.boxShadow = 'none';
                });
            }
        });
        
        calendar.render();
        
        // Today button
        document.getElementById('today-btn').addEventListener('click', function() {
            calendar.today();
        });
        
    } catch (error) {
        console.error('Calendar initialization error:', error);
        calendarEl.innerHTML = '<div class="text-center py-20"><div class="bg-red-100 dark:bg-red-900 p-8 rounded-2xl w-32 h-32 mx-auto mb-6 flex items-center justify-center shadow-lg"><i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-4xl"></i></div><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Gagal Memuat Kalender</h3><p class="text-gray-500 dark:text-gray-400 text-lg">Silakan refresh halaman atau hubungi administrator</p></div>';
    }
    
    // All day checkbox functionality
    const allDayCheckbox = document.getElementById('is_all_day');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    allDayCheckbox.addEventListener('change', function() {
        if (this.checked) {
            startTimeInput.disabled = true;
            endTimeInput.disabled = true;
            startTimeInput.value = '';
            endTimeInput.value = '';
            startTimeInput.parentElement.style.opacity = '0.5';
            endTimeInput.parentElement.style.opacity = '0.5';
        } else {
            startTimeInput.disabled = false;
            endTimeInput.disabled = false;
            startTimeInput.parentElement.style.opacity = '1';
            endTimeInput.parentElement.style.opacity = '1';
        }
    });
    
    // Edit form all day checkbox
    const editAllDayCheckbox = document.getElementById('edit_is_all_day');
    const editStartTimeInput = document.getElementById('edit_start_time');
    const editEndTimeInput = document.getElementById('edit_end_time');
    
    editAllDayCheckbox.addEventListener('change', function() {
        if (this.checked) {
            editStartTimeInput.disabled = true;
            editEndTimeInput.disabled = true;
            editStartTimeInput.value = '';
            editEndTimeInput.value = '';
            editStartTimeInput.parentElement.style.opacity = '0.5';
            editEndTimeInput.parentElement.style.opacity = '0.5';
        } else {
            editStartTimeInput.disabled = false;
            editEndTimeInput.disabled = false;
            editStartTimeInput.parentElement.style.opacity = '1';
            editEndTimeInput.parentElement.style.opacity = '1';
        }
    });
});

// Enhanced color picker functionality
document.querySelectorAll('.color-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.color-btn').forEach(b => {
            b.classList.remove('ring-4', 'ring-blue-200', 'scale-110');
        });
        this.classList.add('ring-4', 'ring-blue-200', 'scale-110');
        document.querySelector('#addEventForm input[name="color"]').value = this.dataset.color;
    });
});

document.querySelectorAll('.edit-color-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.edit-color-btn').forEach(b => {
            b.classList.remove('ring-4', 'ring-green-200', 'scale-110');
        });
        this.classList.add('ring-4', 'ring-green-200', 'scale-110');
        document.querySelector('#editEventForm input[name="color"]').value = this.dataset.color;
    });
});

function showAddEventModal() {
    document.getElementById('addEventModal').classList.remove('hidden');
    document.getElementById('addEventModal').classList.add('flex');
    // Set default date to today
    document.querySelector('#addEventForm input[name="start_date"]').value = new Date().toISOString().split('T')[0];
}

function closeModal() {
    document.getElementById('addEventModal').classList.add('hidden');
    document.getElementById('addEventModal').classList.remove('flex');
    document.getElementById('addEventForm').reset();
    // Reset color selection
    document.querySelectorAll('.color-btn').forEach(b => {
        b.classList.remove('ring-4', 'ring-blue-200', 'scale-110');
    });
    document.querySelector('.color-btn[data-color="#3b82f6"]').classList.add('ring-4', 'ring-blue-200', 'scale-110');
    // Reset time inputs
    document.getElementById('start_time').disabled = false;
    document.getElementById('end_time').disabled = false;
    document.getElementById('start_time').parentElement.style.opacity = '1';
    document.getElementById('end_time').parentElement.style.opacity = '1';
}

function showEditEventModal(eventId) {
    currentEventId = eventId;
    
    fetch(`{{ route("admin.calendar.index") }}/events/${eventId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const form = document.getElementById('editEventForm');
                form.querySelector('input[name="event_id"]').value = data.event.id;
                form.querySelector('input[name="title"]').value = data.event.title;
                form.querySelector('select[name="type"]').value = data.event.type;
                form.querySelector('input[name="start_date"]').value = data.event.start_date;
                form.querySelector('input[name="end_date"]').value = data.event.end_date || '';
                form.querySelector('input[name="start_time"]').value = data.event.start_time || '';
                form.querySelector('input[name="end_time"]').value = data.event.end_time || '';
                form.querySelector('input[name="location"]').value = data.event.location || '';
                form.querySelector('textarea[name="description"]').value = data.event.description || '';
                form.querySelector('input[name="color"]').value = data.event.color;
                
                // Set all day checkbox
                const isAllDay = data.event.is_all_day || (!data.event.start_time && !data.event.end_time);
                form.querySelector('input[name="is_all_day"]').checked = isAllDay;
                
                // Enable/disable time inputs based on all day
                const editStartTime = form.querySelector('input[name="start_time"]');
                const editEndTime = form.querySelector('input[name="end_time"]');
                editStartTime.disabled = isAllDay;
                editEndTime.disabled = isAllDay;
                editStartTime.parentElement.style.opacity = isAllDay ? '0.5' : '1';
                editEndTime.parentElement.style.opacity = isAllDay ? '0.5' : '1';
                
                // Set color selection
                document.querySelectorAll('.edit-color-btn').forEach(btn => {
                    btn.classList.remove('ring-4', 'ring-green-200', 'scale-110');
                    if (btn.dataset.color === data.event.color) {
                        btn.classList.add('ring-4', 'ring-green-200', 'scale-110');
                    }
                });
                
                document.getElementById('editEventModal').classList.remove('hidden');
                document.getElementById('editEventModal').classList.add('flex');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', 'Gagal memuat data event');
        });
}

function closeEditModal() {
    document.getElementById('editEventModal').classList.add('hidden');
    document.getElementById('editEventModal').classList.remove('flex');
    currentEventId = null;
}

function deleteEvent() {
    if (!currentEventId) return;
    
    if (confirm('Apakah Anda yakin ingin menghapus event ini?')) {
        fetch(`{{ route("admin.calendar.index") }}/events/${currentEventId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeEditModal();
                calendar.refetchEvents();
                showMessage('success', data.message);
                setTimeout(() => location.reload(), 1000); // Refresh statistics
            } else {
                showMessage('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', 'Terjadi kesalahan saat menghapus event');
        });
    }
}

function syncFromAgenda() {
    if (confirm('Sinkronisasi agenda ke kalender? Ini akan menambahkan agenda yang belum ada di kalender.')) {
        // Show loading state
        const syncBtn = event.target;
        const originalText = syncBtn.innerHTML;
        syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Sinkronisasi...';
        syncBtn.disabled = true;
        
        fetch('{{ route("admin.calendar.index") }}/sync-agenda', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.refetchEvents();
                showMessage('success', data.message);
                setTimeout(() => location.reload(), 1000); // Refresh statistics
            } else {
                showMessage('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', 'Terjadi kesalahan saat sinkronisasi');
        })
        .finally(() => {
            syncBtn.innerHTML = originalText;
            syncBtn.disabled = false;
        });
    }
}

function showMessage(type, message) {
    // Create enhanced notification
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 transform translate-x-full transition-transform duration-300`;
    
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    notification.innerHTML = `
        <div class="p-4">
            <div class="flex items-center">
                <div class="${bgColor} p-2 rounded-lg mr-3">
                    <i class="fas ${icon} text-white"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 dark:text-white">${type === 'success' ? 'Berhasil' : 'Error'}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Form submission for add event
document.getElementById('addEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("admin.calendar.events.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            calendar.refetchEvents();
            showMessage('success', data.message);
            setTimeout(() => location.reload(), 1000); // Refresh statistics
        } else {
            showMessage('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('error', 'Terjadi kesalahan saat menyimpan event');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Form submission for edit event
document.getElementById('editEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!currentEventId) return;
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupdate...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch(`{{ route("admin.calendar.index") }}/events/${currentEventId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEditModal();
            calendar.refetchEvents();
            showMessage('success', data.message);
            setTimeout(() => location.reload(), 1000); // Refresh statistics
        } else {
            showMessage('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('error', 'Terjadi kesalahan saat mengupdate event');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
@endpush