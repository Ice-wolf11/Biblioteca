@extends('template')
@section('title', 'Actualizar Area')
@push('css')
    
@endpush

@section('content')
    <h1 class="mt-4 text-center">Actualizar Area</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('areas.index')}}">Areas</a></li>
        <li class="breadcrumb-item" active>Actualizar Area</li>
    </ol>
    <div class="container w-100 border border-3 corder-primary rounded p-4 mt-3">
        <form action="{{route('areas.update',['area'=>$area])}}" method="POST">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="descripcion" class="form-label">Nombre:</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{old('descripcion', $area->descripcion)}}">
                    @error('descripcion')
                        <small class="text-danger">{{'*'.$message }}</small>
                    @enderror
                </div>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-4">Guardar</button>
                <button type="reset" class="btn btn-secondary mt-4">Reiniciar</button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    
@endpush