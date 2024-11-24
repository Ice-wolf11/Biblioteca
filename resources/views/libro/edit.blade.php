@extends('template')
@section('title', 'Administrar Libro')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
@endpush

@section('content')
    <h1 class="mt-4 text-center">Administrar Libro</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('libros.index') }}">Libros</a></li>
        <li class="breadcrumb-item active">Administrar Libro</li>
    </ol>
    <div class="container w-75 border border-3 border-primary rounded p-4 mt-3">
        <div class="row">
            <!-- Columna izquierda: formulario -->
            <div class="col-md-8">
                <form action="{{ route('libros.update', ['libro' => $libro->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $libro->titulo) }}">
                        @error('titulo')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha Publicación:</label>
                        <input type="date" name="fecha_publicacion" id="fecha_publicacion" class="form-control" value="{{ old('fecha', $libro->fecha_publicacion) }}">
                        @error('fecha_publicacion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="portada" class="form-label">Portada:</label>
                        <input type="file" name="portada" id="portada" class="form-control">
                        @error('portada')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class=" mb-3"> 
                        <div class="col-md-8"> 
                            <label for="autores" class="form-label">Autor:</label> 
                            <select data-size="4" title="Seleccione un autor" data-live-search="true" name="autores[]" id="autores" class="form-control selectpicker show-tick"> 
                                @foreach ($autores as $item) 
                                    <option value="{{$item->id}}" {{ (in_array($item->id , old('autores',[]))) ? 'selected' : '' }}>{{$item->Nombre}}</option>
                                @endforeach 
                            </select> 
                            @error('autores') 
                                <small class="text-danger">{{ '*' . $message }}</small> 
                            @enderror 
                        </div> 
                    </div>
                    <div class="mb-3">
                        <div class="col-md-8">
                            <label for="categorias" class="form-label">Categorías:</label>
                            <select data-size="4" title="Seleccione las categorías" data-live-search="true" name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                                @foreach ($categorias as $item)
                                    <option value="{{$item->id}}" {{ (in_array($item->id , old('categorias',[]))) ? 'selected' : '' }}>{{$item->nombre}}</option>
                                @endforeach
                            </select>
                            @error('categorias')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- Columna derecha: imagen de portada -->
            <div class="col-md-4 text-center">
                @if($libro->ruta_portada)
                    <img src="{{ asset('storage/private/' . $libro->ruta_portada) }}" alt="Portada del libro" class="img-fluid rounded shadow">
                @else
                    <p>No hay portada disponible</p>
                @endif
            </div>
        </div>
    </div>
    <div class="container w-75 border border-3 border-primary rounded p-4 mt-3">
        <div class="mb-4">
            <button class="btn btn-primary btn-icon-split" type="button" data-bs-toggle="modal" data-bs-target="#createModal-{{ $libro->id }}">
                <span class="icon text-white-50">
                    <i class="fas fa-solid fa-plus"></i>
                </span>
                <span class="text">Añadir copia</span>
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($copias as $copia)
                    <tr>
                        <td>{{ $copia->codigo }}</td>
                        <td>{{ $copia->estado }}</td>
                        <td>
                            <div class="d-grid gap-2 d-md-block">
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $copia->id }}">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <!-- Modal Eliminar copias -->
                    <div class="modal fade" id="confirmModal-{{ $copia->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Está seguro de esta acción?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('copia_libros.destroy', ['copia_libro' => $copia->id]) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal para crear copia -->
    <div class="modal fade" id="createModal-{{ $libro->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir Copia</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('copia_libros.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código:</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}">
                            @error('codigo')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@endpush
