@extends('template')
@section('title', 'Agregar Copia')
@push('css')
    
@endpush

@section('content')
<h1 class="mt-4 text-center">Agregar copia</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        
        <li class="breadcrumb-item" active>Agregar Libro</li>
    </ol>
    <div class="container w-50 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('libros.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 justify-content-center mb-2">
                <div class="col-md-8">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $libro->titulo) }}" disabled>
                    @error('titulo')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row g-3 justify-content-center mb-2">
                <div class="col-md-8">
                    <label for="fecha" class="form-label">Fecha Publicación:</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $libro->fecha_publicacion) }}"disabled>
                    @error('fecha')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row g-3 justify-content-center mb-2">
                <div class="col-md-8">
                    <label for="portada" class="form-label">Portada:</label>
                    <input type="file" name="portada" id="portada" class="form-control" value="{{ old('fecha', $libro->ruta_portada) }}">
                    @error('portada')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row g-3 justify-content-center mb-2">
                <div class="col-md-8">
                    <label for="codigo" class="form-label">Codigo:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}" >
                    @error('codigo')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
            </div>

        </form>
    </div>
    
@endsection

@push('js')
    
@endpush