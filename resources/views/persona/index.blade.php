@extends('template')
@section('title', 'Usuarios')
@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

@endpush

@section('content')
@include('layouts.partials.alert')
    <h1 class="mt-4 text-center">Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item" active>Usuarios</li>
    </ol>
    @can('crear-usuario')
    <div class="mb-4">
        <a href="{{route('personas.create')}}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-solid fa-plus"></i>
            </span>
            <span class="text">Nuevo Registro</span>
        </a>
    </div>
    @endcan
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista Usuarios</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Area</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personas as $persona)
                        <tr>
                            <td>{{$persona->user->name}}</td>
                            <td>{{$persona->area->descripcion}}</td>
                            <td>{{$persona->user->getRoleNames()->first()}}</td>
                            <td>
                                <div class="d-grid gap-2 d-md-block">
                                    @can('editar-usuario')
                                    <form action="{{route('personas.edit',['persona'=>$persona])}}" class="d-inline">@csrf<button class="btn btn-success" type="submit">Editar</button></form>
                                    @endcan
                                    @can('eliminar-usuario')
                                    <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$persona->id}}">Eliminar</button>
                                    @endcan   
                                </div>    
                            </td>               
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal-{{$persona->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="{{route('personas.destroy',['persona'=>$persona->id])}}" method="POST">
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
    </div>
@endsection

@push('js')


@endpush