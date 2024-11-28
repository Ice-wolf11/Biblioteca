@extends('template')
@section('title', 'Prestamos')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
@endpush

@section('content')
@include('partials.select')
@include('layouts.partials.alert')

<h1 class="mt-4 text-center">Prestar Libro</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('prestamos.index') }}">Prestamos</a></li>
    <li class="breadcrumb-item active">Prestar Libro</li>
</ol>

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    </script>
@endif

<div class="container w-75 border border-3 border-primary rounded p-4 mt-3">
    <div class="row">
        <!-- Columna izquierda: formulario -->
        <div class="col-md-8">
            <form action="{{ route('prestamos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $libro->titulo }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="titulo" class="form-label">copia:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $libro->titulo }}" disabled>
                </div>
                
                <!-- Mostrar las copias disponibles -->
                
                <div class="mb-3">
                    <label for="copias_disponibles" class="form-label">Copias Disponible:</label>
                    @php
                        $copiasDisponibles = $libro->copia_libros->where('estado', 'disponible');
                    @endphp
                    @if ($copiasDisponibles->count() > 0)
                        <select name="id_copia" id="id_copia" class="form-select" required>
                            <option value="">Selecciona una copia</option>
                            @foreach ($copiasDisponibles as $copia)
                                <option value="{{ $copia->id }}">{{ $copia->codigo }}</option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-danger">Lo sentimos, no hay copias disponibles en este momento.</p>
                    @endif
                </div>

                <!-- Aquí, necesitarás enviar también la persona que está haciendo la reserva -->
                <input type="hidden" name="id_persona" value="{{ auth()->user()->persona->id }}">

                <div class="text-center">
                    <button type="submit" class="btn btn-success" @if ($copiasDisponibles->count() == 0) disabled @endif>Reservar</button>
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
