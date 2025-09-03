@extends('layouts.public')

@section('title', 'Detail Foto')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4">Detail Foto</h2>
    <img src="{{ asset('uploads/gallery/'.$photo->filename) }}" class="img-fluid rounded shadow">
    <p class="mt-3">{{ $photo->filename }}</p>
    <a href="{{ route('gallery.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
