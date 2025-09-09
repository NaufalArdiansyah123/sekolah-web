{{-- resources/views/admin/posts/slideshow/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Slideshow Management')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Slideshow Management</h1>
                        <p class="text-sm text-gray-600 mt-1">Kelola slideshow untuk homepage</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.posts.slideshow.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Slideshow
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <div class="flex">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <div class="flex">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Slideshow Grid -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Slideshow</h2>
                    <div class="text-sm text-gray-500">
                        Total: {{ $slideshows->total() }} slideshow
                    </div>
                </div>
            </div>
            
            @if($slideshows->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slideshow</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($slideshows as $slideshow)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-16 w-24">
                                                @if($slideshow->image)
                                                    <img class="h-16 w-24 rounded-lg object-cover shadow-sm" 
                                                         src="{{ asset('storage/' . $slideshow->image) }}" 
                                                         alt="{{ $slideshow->title }}"
                                                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTQgMTZMOC41ODU3OSAxMS40MTQyQzguOTYwODYgMTEuMDM5MSA5LjU0Mjg5IDEwLjgzNzkgMTAuMTIxMyAxMS4wMzAzTDE2IDEyLjVNMTMgMTBMMTQuNTg1OCA4LjQxNDIxQzE0Ljk2MDkgOC4wMzkxNCAxNS41NDI4IDcuODM3ODUgMTYuMTIxMiA4LjAzMDI1TDIwIDE0TTE2IDZINi4wMUM2LjAwMzM1IDYgNiA2LjAwMzM1IDYgNi4wMVYxNy45OUM2IDE3Ljk5NjcgNi4wMDMzNSAxOCA2LjAxIDE4SDE3Ljk5QzE3Ljk5NjcgMTggMTggMTcuOTk2NyAxOCAxNy45OVY2LjAxQzE4IDYuMDAzMzUgMTcuOTk2NyA2IDE3Ljk5IDZIMTZMOTI2IDJINmMtMi4yMDkxNCAwLTQgMS43OTA4Ni00IDR2MTJDMIASMC4yMDkxNCAyIDIgMkI2LjIwOTE0IDIgOCAyaDE2QzIyIDIgMjEuNzkwOSAyIDIwIDJaIiBzdHJva2U9IiNkMWQ1ZGIiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=';">
                                                @else
                                                    <div class="h-16 w-24 rounded-lg bg-gray-200 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $slideshow->title }}</div>
                                                @if($slideshow->description)
                                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($slideshow->description, 50) }}</div>
                                                @else
                                                    <div class="text-sm text-gray-400 italic">Tidak ada deskripsi</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $slideshow->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $slideshow->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-100 text-gray-700">
                                            {{ $slideshow->order ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $slideshow->created_at->format('d M Y') }}<br>
                                        <span class="text-xs text-gray-400">{{ $slideshow->created_at->format('H:i') }}</span>
                                        @if($slideshow->user)
                                            <div class="text-xs text-gray-400 mt-1">by {{ $slideshow->user->name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-2">
                                            <!-- Preview Button -->
                                            @if($slideshow->image)
                                                <button type="button" 
                                                        onclick="showImageModal('{{ asset('storage/' . $slideshow->image) }}', '{{ $slideshow->title }}')"
                                                        class="text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 px-3 py-1 rounded transition-colors duration-200"
                                                        title="Lihat gambar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                            @endif

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.posts.slideshow.edit', $slideshow->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded transition-colors duration-200"
                                               title="Edit slideshow">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>

                                            <!-- Hidden form for deletion -->
                                           <form action="{{ route('admin.posts.slideshow.destroy', $slideshow->id) }}" method="POST" onsubmit="return confirm('Yakin hapus slideshow ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($slideshows->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $slideshows->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada slideshow</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat slideshow pertama untuk homepage.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.posts.slideshow.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Slideshow
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between pb-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Preview Gambar</h3>
                <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="text-center">
                <img id="modalImage" class="max-w-full h-auto rounded-lg shadow-md" src="" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="deleteMessage">
                    Apakah Anda yakin ingin menghapus slideshow ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md hover:bg-gray-400 transition-colors duration-200">
                    Batal
                </button>
                <button id="confirmDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md hover:bg-red-700 transition-colors duration-200">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Image Modal Functions
function showImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Delete Confirmation Functions
let deleteFormId = '';

function confirmDelete(slideshowId, title) {
    deleteFormId = 'delete-form-' + slideshowId;
    document.getElementById('deleteMessage').textContent = 
        `Apakah Anda yakin ingin menghapus slideshow "${title}"? Tindakan ini tidak dapat dibatalkan.`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    deleteFormId = '';
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteFormId) {
        document.getElementById(deleteFormId).submit();
    }
});

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const imageModal = document.getElementById('imageModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === imageModal) {
        closeImageModal();
    }
    
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
        closeDeleteModal();
    }
});
</script>
@endsection