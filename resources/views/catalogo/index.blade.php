@extends('template')
@section('title', 'Catálogo de Libros')

@push('css')
<!-- Agrega estilos opcionales -->
@endpush

@section('content')
@include('layouts.partials.alert')
<h1 class="mt-4 text-center">Catálogo de Libros</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Catálogo</li>
</ol>

<div class="container">
    <!-- Filtro de categorías -->
    <div class="mb-4">
        <label for="filter-categories" class="form-label">Filtrar por categoría:</label>
        <select id="filter-categories" class="form-select">
            <option value="">Todas</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
    </div>

    <!-- Contenedor dinámico para los libros -->
    <div id="book-container" class="row">
        @forelse ($libros as $libro)
        <div class="col-md-3 mb-4">
            <div class="text-decoration-none">
                <div class="card w-6 shadow-sm">
                    <img class="card-img-top" src="{{ asset('storage/libros/' . $libro->ruta_portada) }}" alt="portada">  
                    <div class="card-body text-left">
                        <h5 class="card-title">{{ $libro->titulo }}</h5>
                        <p>Copias Disponibles: 
                            {{ $libro->copia_libros->where('estado', 'disponible')->count() }}
                        </p>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <a href="{{route('prestamos.create-catalogo', $libro->id)}}" class="btn btn-success">Prestamo</a>
                        <a href="{{ route('reservas.create', $libro->id) }}" class="btn btn-primary">Reserva</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center text-muted">No hay libros disponibles.</p>
        </div>
        @endforelse
    </div>
    
    <!-- Controles de paginación -->
    <<div class="d-flex justify-content-center mt-4">
        {{ $libros->links('pagination::bootstrap-4') }}
    </div>
    
    
</div>
@endsection

@push('js')
<script>
    // Escuchar el cambio en el filtro de categorías
    document.getElementById('filter-categories').addEventListener('change', function () {
        const categoryId = this.value;

        // Realizar solicitud AJAX para obtener los libros filtrados
        fetch(`/catalogo/filter?categoria_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('book-container');
                container.innerHTML = ''; // Limpiar el contenedor de libros

                // Validar si hay libros en la respuesta
                if (data.length === 0) {
                    container.innerHTML = `
                        <div class="col-12">
                            <p class="text-center text-muted">No hay libros disponibles en esta categoría.</p>
                        </div>
                    `;
                } else {
                    // Iterar sobre los libros devueltos y actualizar el contenedor
                    data.forEach(libro => {
                        const bookCard = `
                            <div class="col-md-3 mb-4">
                                <div class="text-decoration-none">
                                    <div class="card w-6 shadow-sm">
                                        <img class="card-img-top" src="/storage/libros/${libro.ruta_portada}" alt="portada">  
                                        <div class="card-body text-left">
                                            <h5 class="card-title">${libro.titulo}</h5> 
                                            <p>Copias Disponibles: ${libro.copias_disponibles}</p>
                                        </div>
                                        <div class="d-flex justify-content-center gap-2 mb-2">
                                            <a class="btn btn-success">Prestamo</a>
                                            <a href="/reservas/create/${libro.id}" class="btn btn-primary">Reserva</a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        container.innerHTML += bookCard; // Agregar los nuevos libros al contenedor
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>

@endpush
