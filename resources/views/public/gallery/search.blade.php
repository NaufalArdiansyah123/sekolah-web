@extends('layouts.public')

@section('title', 'Search Gallery')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            Hasil Pencarian: "{{ $query }}"
        </h1>
        
        @if(isset($albums) && count($albums) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($albums as $album)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if(isset($album['photos'][0]))
                            <img src="{{ asset('storage/' . $album['photos'][0]['thumbnail_path']) }}" 
                                 alt="{{ $album['title'] }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $album['title'] }}</h3>
                            @if(!empty($album['description']))
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($album['description'], 100) }}</p>
                            @endif
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>{{ $album['photo_count'] ?? count($album['photos'] ?? []) }} Foto</span>
                                <span>{{ isset($album['created_at']) ? \Carbon\Carbon::parse($album['created_at'])->locale('id')->diffForHumans() : '' }}</span>
                            </div>
                            <a href="{{ route('gallery.show', $album['slug']) }}" 
                               class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                                Lihat Album
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-gray-600">Coba gunakan kata kunci yang berbeda atau periksa ejaan Anda.</p>
                <a href="{{ route('gallery.index') }}" 
                   class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">
                    Kembali ke Gallery
                </a>
            </div>
        @endif
    </div>
</div>
@endsection