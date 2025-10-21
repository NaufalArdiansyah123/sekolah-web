@extends('layouts.admin')

@section('title', 'Lihat QR Guru')

@section('content')
<div class="container-fluid py-3">
    <div class="card">
        <div class="card-header">QR Guru: {{ $teacher->name }}</div>
        <div class="card-body text-center">
            @if($url)
                <img src="{{ $url }}" alt="QR" style="max-width:360px; width:100%; height:auto;">
                <div class="mt-3">
                    <a class="btn btn-primary" href="{{ route('admin.qr-teacher.download', $teacher) }}"><i class="fas fa-download"></i> Unduh PNG</a>
                </div>
                <img id="qrImageSrc" data-src="{{ $url }}" alt="" style="display:none;">
            @else
                <div class="alert alert-warning">QR belum dibuat. Klik Generate di halaman daftar.</div>
            @endif
        </div>
    </div>
</div>
@endsection
