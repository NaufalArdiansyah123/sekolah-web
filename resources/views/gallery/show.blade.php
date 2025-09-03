@extends('layouts.app')

@section('content')
<div class="container">
  <h1>{{ $gallery->nama }}</h1>
  <div class="row">
    @foreach($gallery->photos as $photo)
      <div class="col-md-3 mb-3">
        <img src="{{ asset('storage/' . $photo->path) }}" class="img-fluid rounded" alt="">
      </div>
    @endforeach
  </div>
</div>
@endsection
