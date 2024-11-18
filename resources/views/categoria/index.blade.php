@extends('template')
@section('title', 'Categorias')
@push('css')
    
@endpush

@section('content')
    <h1 class="mt-4 text-center">Categorias</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item" active>Categorias</li>
    </ol>
    <div class="mb-4">
        <a href="#" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-solid fa-plus"></i>
            </span>
            <span class="text">Nuevo Registro</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista categorias</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    
@endpush