<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('panel')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('panel')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @if (auth()->user()->hasAnyPermission(['ver-categoria', 'ver-autor', 'ver-libro']))
    <div class="sidebar-heading">Admin. Libros</div>
    @endif
    @can('ver-categoria')
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('categorias.index')}}">
            <i class="fas fa-solid fa-tag"></i>
            <span>Categorias</span></a>
    </li>
    @endcan

    @can('ver-autor')
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('autores.index')}}">
            <i class="fas fa-regular fa-address-book"></i>
            <span>Autores</span></a>
    </li>
    @endcan

    @can('ver-libro')
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('libros.index')}}">
            <i class="fas fa-solid fa-book"></i>
            <span>Libros</span></a>
    </li>
    @endcan
    @if (auth()->user()->hasAnyPermission(['ver-catalogo', 'ver-reserva', 'ver-prestamo']))
    <div class="sidebar-heading">Admin. Prestamos </div>
    @endif
    @can('ver-catalogo')
    <li class="nav-item">
        <a class="nav-link" href="{{route('catalogo.index')}}">
            <i class="fas fa-solid fa-eye"></i>
            <span>Catalogo</span></a>
    </li>
    @endcan
    @if (auth()->user()->hasAnyPermission(['ver-reserva', 'ver-mis-reservas']))
    <li class="nav-item">
        <a class="nav-link" href="{{route('reservas.index')}}">
            <i class="fas fa-solid fa-folder-open"></i>
            <span>Reservas</span></a>
    </li>
    @endif
    @if (auth()->user()->hasAnyPermission(['ver-prestamo', 'ver-mis-prestamos']))
    <li class="nav-item">
        <a class="nav-link" href="{{route('prestamos.index')}}">
            <i class="fas fa-solid fa-bookmark"></i>
            <span>Prestamos</span></a>
    </li>
    @endif


    <!--usuarios-->
    @if (auth()->user()->hasAnyPermission(['ver-area', 'ver-usuario', 'ver-roles']))
    <!-- Mostrar esta sección si tiene alguno de los permisos -->
    <div class="sidebar-heading">Admin. Users</div>
    @endif
    

    @can('ver-area')
    <li class="nav-item">
        <a class="nav-link" href="{{route('areas.index')}}">
            <i class="fas fa-solid fa-bars"></i>
            <span>Areas</span></a>
    </li>
    @endcan
    <!-- Nav Item - Charts -->
    @can('ver-usuario')
    <li class="nav-item">
        <a class="nav-link" href="{{route('personas.index')}}">
            <i class="fas fa-solid fa-user"></i>
            <span>Usuarios</span></a>
    </li>
    @endcan
    <!-- Nav Item - Charts -->
    @can('ver-roles')
    <li class="nav-item">
        <a class="nav-link" href="{{route('roles.index')}}">
            <i class="fas fa-solid fa-ghost"></i>
            <span>Roles y permisos</span></a>
    </li>
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>