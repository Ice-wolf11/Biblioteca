@extends('template')
@section('title', 'Nueva Area')
@push('css')
    
@endpush

@section('content')
    <h1 class="mt-4 text-center">Agregar Area</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('areas.index')}}">Areas</a></li>
        <li class="breadcrumb-item" active>Agregar Areas</li>
    </ol>
    <div class="container w-100 border border-3 corder-primary rounded p-4 mt-3">
        <form action="{{route('areas.store')}}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                    @error('nombre')
                        <small class="text-danger">{{'*'.$message }}</small>
                    @enderror
                </div>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-4">Guardar</button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    
@endpush