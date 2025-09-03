@extends('layouts.public')

@section('title', 'Photo Gallery')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('gallery.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Galeri</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $gallery->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Gallery Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $gallery->title }}</h1>
        @if($gallery->description)
            <p class="text-gray-600 mb-4">{{ $gallery->description }}</p>
        @endif
        <div class="flex items-center text-sm text-gray-500">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>
            {{ $gallery->created_at->format('d F Y') }}
        </div>
    </div>

    <!-- Photos Grid -->
    @if($gallery->photos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($gallery->photos as $index => $photo)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="aspect-w-1 aspect-h-1">
                        <img 
                            src="{{ asset('storage/' . $photo->image) }}" 
                            alt="{{ $photo->caption ?? $gallery->title }}"
                            class="w-full h-64 object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                            onclick="openLightbox({{ $index }})"
                            loading="lazy"
                        >
                    </div>
                    @if($photo->caption)
                        <div class="p-4">
                            <p class="text-sm text-gray-600">{{ $photo->caption }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada foto</h3>
            <p class="text-gray-500">Galeri ini belum memiliki foto yang diunggah.</p>
        </div>
    @endif
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center">
    <div class="relative max-w-4xl max-h-full p-4">
        <!-- Close Button -->
        <button 
            onclick="closeLightbox()" 
            class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10"
        >
            &times;
        </button>
        
        <!-- Previous Button -->
        <button 
            onclick="previousImage()" 
            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10"
        >
            &#8249;
        </button>
        
        <!-- Next Button -->
        <button 
            onclick="nextImage()" 
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10"
        >
            &#8250;
        </button>
        
        <!-- Image -->
        <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain">
        
        <!-- Caption -->
        <div id="lightbox-caption" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-center bg-black bg-opacity-50 px-4 py-2 rounded"></div>
    </div>
</div>

<script>
let currentImageIndex = 0;
const images = [
    @foreach($gallery->photos as $photo)
    {
        src: "{{ asset('storage/' . $photo->image) }}",
        caption: "{{ $photo->caption ?? '' }}"
    },
    @endforeach
];

function openLightbox(index) {
    currentImageIndex = index;
    updateLightboxImage();
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function previousImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    updateLightboxImage();
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    updateLightboxImage();
}

function updateLightboxImage() {
    if (images.length > 0) {
        const image = images[currentImageIndex];
        document.getElementById('lightbox-image').src = image.src;
        document.getElementById('lightbox-caption').textContent = image.caption;
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').style.display === 'flex') {
        switch(e.key) {
            case 'Escape':
                closeLightbox();
                break;
            case 'ArrowLeft':
                previousImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
        }
    }
});

// Close lightbox when clicking outside image
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>
@endsections