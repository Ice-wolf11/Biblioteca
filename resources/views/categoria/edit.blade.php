@extends('template')
@section('title', 'Editar Categoria')
@push('css')
    
@endpush

@section('content')
    <h1 class="mt-4 text-center">Editar Categoria</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('categorias.index')}}">Categorias</a></li>
        <li class="breadcrumb-item" active>Editar Categorias</li>
    </ol>
    <div class="container w-100 border border-3 corder-primary rounded p-4 mt-3">
        <form action="{{route('categorias.update',['categoria'=>$categoria])}}" method="POST">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $categoria->nombre)}}">
                    @error('nombre')
                        <small class="text-danger">{{'*'.$message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="description" class="form-label">Descripción:</label>
                    <textarea type="text" name="descripcion" id="descripcion" class="form-control" >v{{old('descripcion',$categoria->descripcion)}}</textarea>
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