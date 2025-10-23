@extends('layouts.admin')

@section('title', 'QR Guru')

@push('styles')
    <style>
        .toolbar {
            display: flex;
            gap: .5rem;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .search-input {
            padding: .5rem .75rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            min-width: 240px;
        }

        .btn {
            padding: .5rem .75rem;
            border-radius: 8px;
            font-weight: 600;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-primary {
            background: #3b82f6;
            color: #fff;
        }

        .btn-secondary {
            background: #fff;
            color: #374151;
            border-color: #e5e7eb;
        }

        .btn-success {
            background: #10b981;
            color: #fff;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1rem;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
        }

        .card-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-body {
            padding: 1rem;
        }

        .row {
            display: flex;
            align-items: center;
            gap: .5rem;
            justify-content: space-between;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .muted {
            color: #6b7280;
            font-size: .85rem;
        }

        .actions {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">
        <div class="card mb-3">
            <div class="card-header">Generate QR Code Guru</div>
            <div class="card-body">
                <form method="GET" class="toolbar">
                    <input type="text" name="q" class="search-input" value="{{ request('q') }}"
                        placeholder="Cari nama/NIP/email guru...">
                    <div class="actions">
                        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Cari</button>
                        <button class="btn btn-primary" type="button" onclick="bulkGenerate()"><i class="fas fa-qrcode"></i>
                            Generate QR Terpilih</button>
                    </div>
                </form>
            </div>
        </div>

        <form id="bulkForm">
            <div class="grid">
                @foreach($teachers as $t)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div style="display:flex; align-items:center; gap:.75rem;">
                                    <div class="avatar">{{ mb_substr($t->name, 0, 1) }}</div>
                                    <div>
                                        <div style="font-weight:700">{{ $t->name }}</div>
                                        <div class="muted">NIP: {{ $t->nip ?? '-' }}</div>
                                        <div class="muted">{{ $t->email ?? '' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <input type="checkbox" name="ids[]" value="{{ $t->id }}">
                                </div>
                            </div>
                            <div class="actions" style="margin-top:.75rem;">
                                @if($t->qrTeacherAttendance && $t->qrTeacherAttendance->qr_image_path)
                                    <button type="button" class="btn btn-secondary" onclick="previewQr({{ $t->id }})"><i
                                            class="fas fa-eye"></i> Lihat</button>
                                    <button type="button" class="btn btn-success" onclick="generateQr({{ $t->id }})"><i
                                            class="fas fa-qrcode"></i> Regenerate</button>
                                    <a class="btn btn-secondary" href="{{ route('admin.qr-teacher.download', $t) }}"><i
                                            class="fas fa-download"></i> Unduh</a>
                                    <span class="text-green-600 text-sm font-medium"><i class="fas fa-check-circle"></i> Sudah
                                        Generated</span>
                                @else
                                    <button type="button" class="btn btn-secondary" onclick="previewQr({{ $t->id }})"><i
                                            class="fas fa-eye"></i> Lihat</button>
                                    <button type="button" class="btn btn-primary" onclick="generateQr({{ $t->id }})"><i
                                            class="fas fa-qrcode"></i> Generate</button>
                                    <a class="btn btn-secondary" href="{{ route('admin.qr-teacher.download', $t) }}"><i
                                            class="fas fa-download"></i> Unduh</a>
                                    <span class="text-red-600 text-sm font-medium"><i class="fas fa-times-circle"></i> Belum
                                        Generated</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>

        <div class="mt-3">
            {{ $teachers->links() }}
        </div>
    </div>

    <!-- QR Code Modal (styled to match student QR UI) -->
    <div id="qrTeacherModal"
        class="fixed inset-0 bg-black bg-opacity-50 dark:bg-black dark:bg-opacity-70 hidden items-center justify-center z-50"
        onclick="closeTeacherModal()">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 border border-gray-200 dark:border-gray-700"
            onclick="event.stopPropagation()">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-white flex items-center"><i class="fas fa-qrcode mr-2"></i>QR Code
                        Guru</h3>
                    <button onclick="closeTeacherModal()"
                        class="text-white hover:text-gray-200 transition-colors p-1 rounded-lg hover:bg-white/10">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div id="qrTeacherContent" class="text-center">
                    <div
                        class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 dark:border-blue-400 mx-auto">
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mt-3">Memuat...</p>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeTeacherModal()"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">Tutup</button>
                <button type="button" id="downloadTeacherQrBtn"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Download
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function generateQr(id) {
            fetch("{{ url('/admin/qr-teacher/generate') }}/" + id, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showQr(res.url);
                        // Reload page after 2 seconds to update status
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else { alert(res.message || 'Gagal generate QR'); }
                })
                .catch(err => alert('Error: ' + err));
        }

        function previewQr(id) {
            fetch("{{ url('/admin/qr-teacher/view') }}/" + id)
                .then(r => r.text())
                .then(html => {
                    const temp = document.createElement('div');
                    temp.innerHTML = html;
                    const img = temp.querySelector('#qrImageSrc');
                    if (img && img.dataset.src) {
                        showQr(img.dataset.src);
                    } else {
                        // Jika belum ada, coba generate
                        generateQr(id);
                    }
                });
        }

        function showQr(url, meta = null) {
            // Open modal
            const modal = document.getElementById('qrTeacherModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const content = document.getElementById('qrTeacherContent');
            content.innerHTML = `
                        <div class="text-center">
                            <img src="${url}" alt="QR Code" class="max-w-xs mx-auto mb-4 rounded-lg shadow-lg">
                            ${meta ? `<h4 class=\"text-xl font-bold text-gray-900 dark:text-white mb-1\">${meta.name}</h4>
                                      <p class=\"text-gray-600 dark:text-gray-400 mb-4\">NIP: ${meta.nip ?? '-'} | ${meta.email ?? ''}</p>` : ''}
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    QR Code untuk absensi guru
                                </p>
                            </div>
                        </div>
                    `;

            // Setup download button
            const dlBtn = document.getElementById('downloadTeacherQrBtn');
            dlBtn.onclick = () => { window.open(url, '_blank'); };
        }

        function closeTeacherModal() {
            const modal = document.getElementById('qrTeacherModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function bulkGenerate() {
            const form = document.getElementById('bulkForm');
            const data = new FormData(form);
            const ids = data.getAll('ids[]');
            if (!ids.length) { alert('Pilih minimal satu guru.'); return; }

            fetch("{{ route('admin.qr-teacher.generate-bulk') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: new URLSearchParams(ids.map(id => ['ids[]', id]))
            })
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.results && res.results.length) {
                        // Tampilkan QR pertama sebagai preview
                        showQr(res.results[0].url);
                        // Reload page after 2 seconds to update status
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        alert('Proses selesai namun tidak ada hasil dikembalikan.');
                    }
                })
                .catch(err => alert('Error: ' + err));
        }
    </script>
@endpush