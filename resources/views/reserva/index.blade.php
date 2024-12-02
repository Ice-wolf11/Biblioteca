@extends('template')
@section('title', 'Reservas')
@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

@endpush

@section('content')
@include('layouts.partials.alert')
    <h1 class="mt-4 text-center">Reservas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item" active>Reservas</li>
    </ol>
    

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista Reservas</h6>
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
                        @foreach ($reservas as $reserva)
                        @if (auth()->user()->hasAllPermissions(['ver-reserva', 'ver-mis-reservas']))
                            <tr>
                                <td>{{$reserva->persona->user->name}}</td>
                                <td>{{$reserva->copia_libro->libro->titulo}}</td>
                                <td>{{$reserva->copia_libro->codigo}}</td>
                                @if ($reserva->estado == 'activo')
                                        <td><p class="badge text-bg-success">{{ $reserva->estado }}</p></td>
                                @elseif ($reserva->estado == 'inactivo')
                                        <td><p class="badge text-bg-danger">{{ $reserva->estado }}</p></td>
                                @endif
                                <td>
                                    <div class="d-grid gap-2 d-md-block">
                                        @can('crear-prestamo')
                                        @if ($reserva->estado == 'activo')
                                            <a class="btn btn-success" href="{{route('prestamos.create-reserva', $reserva->id)}}" type="submit">Crear Prestamo</a>
                                        @else
                                            <button class="btn btn-success"disabled>Crear Prestamo</button>
                                        @endif
                                        @endcan
                                        @can('eliminar-reserva')
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$reserva->id}}">Eliminar</button>
                                        @endcan
                                    </div>    
                                </td>                 
                            </tr>
                        @elseif(auth()->user()->hasAllPermissions(['ver-prestamo']))
                            <tr>
                                <td>{{$reserva->persona->user->name}}</td>
                                <td>{{$reserva->copia_libro->libro->titulo}}</td>
                                <td>{{$reserva->copia_libro->codigo}}</td>
                                @if ($reserva->estado == 'activo')
                                        <td><p class="badge text-bg-success">{{ $reserva->estado }}</p></td>
                                @elseif ($reserva->estado == 'inactivo')
                                        <td><p class="badge text-bg-danger">{{ $reserva->estado }}</p></td>
                                @endif
                                <td>
                                    <div class="d-grid gap-2 d-md-block">
                                        @can('crear-prestamo')
                                        @if ($reserva->estado == 'activo')
                                            <a class="btn btn-success" href="{{route('prestamos.create-reserva', $reserva->id)}}" type="submit">Crear Prestamo</a>
                                        @else
                                            <button class="btn btn-success"disabled>Crear Prestamo</button>
                                        @endif
                                        @endcan
                                        @can('eliminar-reserva')
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$reserva->id}}">Eliminar</button>
                                        @endcan
                                    </div>    
                                </td>                 
                            </tr>
                        @elseif(auth()->user()->hasAllPermissions(['ver-mis-prestamos']))
                            @if ($reserva->persona->id_user == auth()->user()->id)
                                <tr>
                                    <td>{{$reserva->persona->user->name}}</td>
                                    <td>{{$reserva->copia_libro->libro->titulo}}</td>
                                    <td>{{$reserva->copia_libro->codigo}}</td>
                                    @if ($reserva->estado == 'activo')
                                            <td><p class="badge text-bg-success">{{ $reserva->estado }}</p></td>
                                    @elseif ($reserva->estado == 'inactivo')
                                            <td><p class="badge text-bg-danger">{{ $reserva->estado }}</p></td>
                                    @endif
                                    <td>
                                        <div class="d-grid gap-2 d-md-block">
                                            @can('crear-prestamo')
                                            @if ($reserva->estado == 'activo')
                                                <a class="btn btn-success" href="{{route('prestamos.create-reserva', $reserva->id)}}" type="submit">Crear Prestamo</a>
                                            @else
                                                <button class="btn btn-success"disabled>Crear Prestamo</button>
                                            @endif
                                            @endcan
                                            @can('eliminar-reserva')
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$reserva->id}}">Eliminar</button>
                                            @endcan
                                        </div>    
                                    </td>                 
                                </tr>
                            @endif
                        @endif
                        

                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal-{{$reserva->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="{{route('reservas.destroy',['reserva'=>$reserva->id])}}" method="POST">
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