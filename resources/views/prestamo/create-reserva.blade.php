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
        <div class="col-md-8">
            <form action="{{ route('prestamos.store_reserva') }}" method="POST">
                @csrf
                <h4>Usuario</h4>
                <div class="mb-1">
                    <label class="form-label">Nombres y Apellidos: </label>
                    <span>{{ $reserva->persona->nombres }} {{ $reserva->persona->apellidos }}</span>
                </div>
                <div class="mb-1">
                    <label class="form-label">DNI:</label>
                    <span>{{ $reserva->persona->dni }}</span>
                </div>
                <div class="mb-1">
                    <label class="form-label">Dirección:</label>
                    <span>{{ $reserva->persona->direccion }}</span>
                </div>
                <div class="mb-1">
                    <label class="form-label">Teléfono:</label>
                    <span>{{ $reserva->persona->telefono }}</span>
                </div>
                <input type="hidden" name="id_persona" id="id_persona" value="{{$reserva->persona->id}}">
                <h6>Detalle Préstamo</h6>
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $reserva->copia_libro->libro->titulo }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ date('Y-m-d') }}" >
                </div>
                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha Límite:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                </div>
                <input type="hidden" name="id_reserva" value="{{ $reserva->id }}">

                <div class="mb-3">
                    <label for="copia" class="form-label">Copia:</label>
                    <!-- Campo visible: muestra el código -->
                    <input type="text" id="copia" class="form-control" value="{{ $reserva->copia_libro->codigo }}" disabled>
                
                    <!-- Campo oculto: guarda el ID -->
                    <input type="hidden" name="id_copia" value="{{ $reserva->copia_libro->id }}">
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Crear Préstamo</button>
                    <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>

        <div class="col-md-4 text-center">
            @if($reserva->copia_libro->libro->ruta_portada)
                <img src="{{ asset('storage/libros/' . $reserva->copia_libro->libro->ruta_portada) }}" alt="Portada del libro" class="img-fluid rounded shadow">
            @else
                <p>No hay portada disponible</p>
            @endif
        </div>
    </div>
</div>
@endsection
