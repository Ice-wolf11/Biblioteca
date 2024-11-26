@extends('template')
@section('title', 'Catálogo de Libros')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
@endpush

@section('content')
@include('layouts.partials.alert')
<h1 class="mt-4 text-center">Catálogo de Libros</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Catálogo</li>
</ol>
<div class="container ">
<div class="row">
    @foreach ($libros as $libro)
    <div class="col-md-3 mb-4">
        <a href="{{ route('libros.show', $libro->id) }}" class="text-decoration-none">
            <div class="card w-6 shadow-sm">
                <img class="card-img-top " src="{{ asset('storage/libros/' . $libro->ruta_portada) }}" alt="portada">  
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $libro->titulo }}</h5>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
</div>
@endsection

@push('js')
@endpush
