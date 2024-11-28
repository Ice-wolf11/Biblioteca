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
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
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
                            <td>{{$prestamo->persona->user->name}}</td>
                            <td>{{$prestamo->copia_libro->libro->titulo}}</td>
                            <td>{{$prestamo->copia_libro->codigo}}</td>
                            @if ($prestamo->estado == 'activo')
                                    <td><p class="badge text-bg-success">{{ $prestamo->estado }}</p></td>
                            @elseif ($reserva->estado == 'devuelto')
                                    <td><p class="badge text-bg-primary">{{ $prestamo->estado }}</p></td>
                            @endif
                            <td>
                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-success" href="{{route('devoluciones.create')}}" type="submit">Devolución</a>
                                    <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$prestamo->id}}">Detalle</button>
                                    <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$prestamo->id}}">Eliminar</button>
                                       
                                </div>    
                            </td>                 
                        </tr>

                        <!-- Modal -->
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')


@endpush