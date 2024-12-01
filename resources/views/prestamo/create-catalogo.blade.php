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
            <h4>Usuario</h4>
            <form id="busqueda">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <div class="input-group">
                        <input type="text" name="nombre" id="nombre" class="form-control" autocomplete="off">
                        <button type="button" id="buscarBtn" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
            <form action="{{ route('prestamos.store_catalogo') }}" method="POST">
                @csrf
                <input type="hidden" name="id_persona" id="id_persona">
                <div class="mb-1">
                    <label class="form-label">Nombres y Apellidos: </label>
                    <span id="nombre_persona"></span>
                </div>
                <div class="mb-1">
                    <label class="form-label">Dni:</label>
                    <span id="dni_persona"></span>
                </div>
                <div class="mb-1">
                    <label class="form-label">Direccion:</label>
                    <span id="direccion_persona"></span>
                </div>
                <div class="mb-1">
                    <label class="form-label">Telefono:</label>
                    <span id="telefono_persona"></span>
                </div>

                <h4>Detalle prestamo</h4>
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $libro->titulo }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    @error('fecha_inicio')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha Limite:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="" >
                    @error('fecha_fin')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
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
                        @error('id_copia')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    @else
                        <p class="text-danger">Lo sentimos, no hay copias disponibles en este momento.</p>
                    @endif
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success" @if ($copiasDisponibles->count() == 0) disabled @endif>Crear Prestamo</button>
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
<script>
    $(document).ready(function() {
        $('#buscarBtn').on('click', function() {
            var nombre = $('#nombre').val();
            if (nombre) {
                $.ajax({
                    url: "{{ route('persona.search') }}",
                    method: 'GET',
                    data: { nombre: nombre },
                    success: function(response) {
                        if (response) {
                            $('#nombre_persona').text(response.nombres + ' ' + response.apellidos);
                            $('#dni_persona').text(response.dni);
                            $('#direccion_persona').text(response.direccion);
                            $('#telefono_persona').text(response.telefono);
                            $('#id_persona').val(response.id);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'No encontrado',
                                text: 'No se encontró la persona.',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error en la búsqueda.',
                        });
                    }
                });
            }
        });
    });
</script>
@endpush
