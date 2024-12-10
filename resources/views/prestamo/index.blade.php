@extends('template')
@section('title', 'Prestamos')
@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
@endpush

@section('content')
@include('layouts.partials.alert')
    <h1 class="mt-4 text-center">Prestamos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item" active>Prestamos</li>
    </ol>
    

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prestamos Reservas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Titulo</th>
                            <th>Copia</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->persona->user->name }}</td>
                            <td>{{ $prestamo->copia_libro->libro->titulo }}</td>
                            <td>{{ $prestamo->copia_libro->codigo }}</td>
                            <td>
                                @if ($prestamo->estado == 'activo')
                                    <p class="badge text-bg-success">{{ $prestamo->estado }}</p>
                                @elseif ($prestamo->estado == 'devuelto')
                                    <p class="badge text-bg-primary">{{ $prestamo->estado }}</p>
                                @endif
                            </td>
                            <td>
                                <div class="d-grid gap-2 d-md-block">
                                    @if ($prestamo->estado == 'activo')
                                        @can('crear-devolucion')
                                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createModal-{{ $prestamo->id }}">Devolución</button>
                                        @endcan
                                    @else
                                        <button class="btn btn-success" type="button" disabled>Devolución</button>
                                    @endif
                                    <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#detalleModal-{{ $prestamo->id }}">Detalle</button>
                                    @can('eliminar-prestamo')
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $prestamo->id }}">Eliminar</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        <!-- Modal delete -->
                        <div class="modal fade" id="confirmModal-{{$prestamo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                ¿Esta seguro de esta acción?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="{{route('prestamos.destroy',['prestamo'=>$prestamo->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                                
                                </div>
                            </div>
                            </div>
                        </div>
                        <!--modal para crear devoluciones-->
                        <div class="modal fade" id="createModal-{{$prestamo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Creando Devolucion</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('devoluciones.store', ['prestamo'=>$prestamo])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_prestamo" value="{{ $prestamo->id }}">

                                <div class="modal-body container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4>Usuario</h4>
                                            <div class="mb-1">
                                                <label class="form-label">Nombres y Apellidos: </label>
                                                <input type="text"class="form-control" value="{{ $prestamo->persona->nombres, $prestamo->persona->apellidos }}" disabled>
                                            </div>
                                            <div class="mb-1">
                                                <label class="form-label">DNI:</label>
                                                <input type="text"class="form-control" value="{{ $prestamo->persona->dni}}" disabled>
                                            </div>
                                            <h4>Devolucion</h4>
                                            <div class="mb-3">
                                                <label for="titulo" class="form-label">Título:</label>
                                                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $prestamo->copia_libro->libro->titulo }}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha prestamo:</label>
                                                <input type="date" name="fecha_prestamo" id="fecha_prestamo" class="form-control" value="{{$prestamo->fecha_inicio}}" readonly>
                                                @error('fecha')
                                                    <small class="text-danger">{{'*'.$message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha estimada:</label>
                                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $prestamo->fecha_limite}}" readonly>
                                                @error('fecha')
                                                    <small class="text-danger">{{'*'.$message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha devolucion:</label>
                                                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                                                @error('fecha')
                                                    <small class="text-danger">{{'*'.$message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="detalle" class="form-label">Detalle:</label>
                                                <textarea type="text" name="detalle" id="detalle" class="form-control" value="{{old('descripcion')}}"></textarea>
                                                @error('detalle')
                                                    <small class="text-danger">{{'*'.$message }}</small>
                                                @enderror
                                            </div>
                                            <h4>Penalizacion</h4>
                                            <div class="mb-3 form-check">
                                                <!-- Checkbox para habilitar el campo de monto -->
                                                <input type="checkbox" class="form-check-input" id="customCode" name="customCode">
                                                <label class="form-check-label" for="customCode">¿hay penalizacion?</label>
                                            </div>               
                                            <div class="mb-3">
                                                <label for="codigo" class="form-label">Monto:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">S/</span> <!-- Prefijo de moneda -->
                                                    <input 
                                                        type="number" 
                                                        name="monto" 
                                                        id="monto" 
                                                        class="form-control" 
                                                        placeholder="Ingrese el monto"
                                                        min="0" 
                                                        step="0.01" 
                                                        readonly>
                                                </div>
                                                @error('monto')
                                                    <small class="text-danger">{{ '*' . $message }}</small>
                                                @enderror
                                            </div>                             
                                            <div class="mb-3">
                                                <!-- Nuevo campo select para "Libro Extraviado" -->
                                                <label for="extraviado" class="form-label">¿Libro extraviado?</label>
                                                <select class="form-select" id="extraviado" name="extraviado" disabled>
                                                    <option value="no" selected>No</option>
                                                    <option value="si">Sí</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 text-center">
                                            @if($prestamo->copia_libro->libro->ruta_portada)
                                                <img src="{{ asset('storage/libros/' . $prestamo->copia_libro->libro->ruta_portada) }}" alt="Portada del libro" class="img-fluid rounded shadow">
                                            @else
                                                <p>No hay portada disponible</p>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                </div>
                            </form>
                            </div>
                            </div>
                        </div>
                        <!--modal para detalle-->
                        <div class="modal fade" id="detalleModal-{{$prestamo->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del prestamo</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4>Usuario</h4>
                                            <div class="mb-1">
                                                <label class="form-label">Nombres y Apellidos: </label>
                                                <input type="text"class="form-control" value="{{ $prestamo->persona->nombres, $prestamo->persona->apellidos }}" disabled>
                                            </div>
                                            <div class="mb-1">
                                                <label class="form-label">DNI:</label>
                                                <input type="text"class="form-control" value="{{ $prestamo->persona->dni}}" disabled>
                                            </div>
                                            <h4>Devolucion</h4>
                                            <div class="mb-3">
                                                <label for="titulo" class="form-label">Título:</label>
                                                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $prestamo->copia_libro->libro->titulo }}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha Inicio:</label>
                                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $prestamo->fecha_inicio}}" readonly>
                                                @error('fecha')
                                                    <small class="text-danger">{{'*'.$message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha devolucion:</label>
                                                @if($prestamo->devolucione)
                                                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $prestamo->devolucione->fecha}}" readonly>
                                                @else
                                                <p>El libro aun no fue devuelto</p> 
                                                @endif
                                                @error('fecha')
                                                    <small class="text-danger">{{'*'.$message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="detalle" class="form-label">Detalle devolucion:</label>
                                                <textarea type="text" name="detalle" id="detalle" class="form-control" value="{{old('descripcion')}}"readonly>{{ $prestamo->devolucione?->detalle ?? 'No hay detalles de devolución' }}</textarea>
                                                @error('detalle')
                                                    <small class="text-danger">{{'*'.$message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="detalle" class="form-label">Detalle devolucion:</label>
                                                @if($prestamo->devolucione)
                                                    @if($prestamo->devolucione->estado == 'A tiempo')
                                                        <p class="badge text-bg-success">{{ $prestamo->devolucione->estado }}</p>
                                                    @elseif($prestamo->devolucione->estado == 'Atrasado')
                                                        <p class="badge text-bg-danger">{{ $prestamo->devolucione->estado }}</p>
                                                    @endif
                                                @else
                                                    <p>El libro aun no fue devuelto</p> 
                                                @endif
                                            </div>
                                            <h4>Penalizacion</h4>             
                                            <div class="mb-3">
                                                <label for="codigo" class="form-label">Monto:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">S/</span> <!-- Prefijo de moneda -->
                                                    <input 
                                                        type="number" 
                                                        name="monto" 
                                                        id="monto" 
                                                        class="form-control" 
                                                        value="{{ $prestamo->penalizacione?->monto ?? 0 }}" 
                                                        readonly>
                                                </div>
                                                @error('monto')
                                                    <small class="text-danger">{{ '*' . $message }}</small>
                                                @enderror
                                            </div>
                                            <form action="{{ $prestamo->penalizacione ? route('penalizaciones.update', ['penalizacione' => $prestamo->penalizacione]) : '#' }}" method="POST">
                                                @if($prestamo->penalizacione)
                                                    @method('PATCH')
                                                @endif
                                                @csrf  
                                            <div class="mb-3">
                                                <!-- Campo select para "Estado Penalización" -->
                                                <label for="estado_penalizacion" class="form-label">Estado Penalización</label>
                                                @if($prestamo->penalizacione)
                                                <select class="form-select" id="estado_penalizacion" name="estado_penalizacion">
                                                    <option value="activo" {{ old('estado_penalizacion', $prestamo->penalizacione->estado ?? '') == 'activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="pagado" {{ old('estado_penalizacion', $prestamo->penalizacione->estado ?? '') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                                    <option value="anulado" {{ old('estado_penalizacion', $prestamo->penalizacione->estado ?? '') == 'anulado' ? 'selected' : '' }}>Anulado</option>
                                                </select>
                                                @else
                                                <p>No hay penalizacion</p> 
                                                @endif
                                            </div>                          
                                        </div>

                                        <div class="col-md-4 text-center">
                                            @if($prestamo->copia_libro->libro->ruta_portada)
                                                <img src="{{ asset('storage/libros/' . $prestamo->copia_libro->libro->ruta_portada) }}" alt="Portada del libro" class="img-fluid rounded shadow">
                                            @else
                                                <p>No hay portada disponible</p>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">    
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                @can('editar-penalizacion')
                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                @endcan
                                </div>
                            </form>
                            </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('customCode');
        const codigoInput = document.getElementById('monto');
        const selectExtraviado = document.getElementById('extraviado');

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                codigoInput.removeAttribute('readonly');
                selectExtraviado.disabled = false; // Habilitar el select si está marcado
            } else {
                codigoInput.setAttribute('readonly', true);
                selectExtraviado.disabled = true; // Deshabilitar el select si no está marcado
            }
        });
    });
</script>
@endpush
