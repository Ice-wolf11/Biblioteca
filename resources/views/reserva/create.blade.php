@extends('template')
@section('title', 'Reservas')

@push('css')
<!-- Puedes agregar estilos opcionales si es necesario -->
@endpush

@section('content')
@include('partials.select')
<h1 class="mt-4 text-center">Reservar Libro</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('catalogo.index') }}">Catálogo</a></li>
    <li class="breadcrumb-item active">Reservar Libro</li>
</ol>

<div class="container w-75 border border-3 border-primary rounded p-4 mt-3">
    <div class="row">
        <!-- Columna izquierda: formulario -->
        <div class="col-md-8">
            <form action="{{ route('reservas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $libro->titulo }}" disabled>
                </div>
                
                <div class="mb-3">
                    <label for="fecha_publicacion" class="form-label">Fecha Publicación:</label>
                    <input type="date" name="fecha_publicacion" id="fecha_publicacion" class="form-control" value="{{ $libro->fecha_publicacion }}" disabled>
                </div>
                
                <div class="mb-3"> 
                    <div class="col-md-8"> 
                        <label for="autores" class="form-label">Autor:</label> 
                        <p>{{ $libro->autor->Nombre }}</p>
                    </div> 
                </div>
                
                <div class="mb-3">
                    <label for="categorias" class="form-label">Categorías:</label>
                    <ul>
                        @foreach ($libro->categoria_libros as $categoria_libro)
                            <li>{{ $categoria_libro->categoria->nombre }}</li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Aquí agregamos el campo de copias disponibles -->
                <div class="mb-3">
                    @php
                        $copiasDisponibles = $libro->copia_libros->where('estado', 'disponible')->count();
                    @endphp
                    @if ($copiasDisponibles > 0)
                        <p class="text-success">¡Hay {{ $copiasDisponibles }} copias disponibles!</p>
                    @else
                        <p class="text-danger">Lo sentimos, no hay copias disponibles en este momento.</p>
                    @endif
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success" @if ($copiasDisponibles <= 0) disabled @endif>Reservar</button>
                    <a href="{{ route('catalogo.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>

        <!-- Columna derecha: imagen de portada -->
        <div class="col-md-4 text-center">
            @if($libro->ruta_portada)
                <img src="{{ asset('storage/libros/' . $libro->ruta_portada) }}" alt="Portada del libro" class="img-fluid rounded shadow">
            @else
                <p>No hay portada disponible</p>
            @endif
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
@endpush
