@extends('template')
@section('title', 'Administrar Libro')
@push('css')
    
@endpush

@section('content')
<h1 class="mt-4 text-center">Administrar Libro</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('libros.index')}}">Libros</a></li>
        <li class="breadcrumb-item" active>Agregar Libro</li>
    </ol>
    <div class="container w-50 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('libros.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 justify-content-center mb-2">
                <div class="col-md-8">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $libro->titulo) }}" >
                    @error('titulo')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row g-3 justify-content-center mb-2">
                <div class="col-md-8">
                    <label for="fecha" class="form-label">Fecha Publicación:</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha') }}">
                    @error('fecha')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row g-3 justify-content-center mb-2">
                <div class="col-md-8">
                    <label for="portada" class="form-label">Portada:</label>
                    <input type="file" name="portada" id="portada" class="form-control"disabled>
                    @error('portada')
                        <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row g-3 justify-content-center mb-2"> 
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
            <div class="row g-3 justify-content-center mb-2">
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
            <div class="row g-3 justify-content-center">
                <div class="col-md-8 text-center">
                    <button type="submit" class="btn btn-primary mt-4">Guardar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    
@endpush