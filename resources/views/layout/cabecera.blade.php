<nav class="app-header navbar navbar-expand bg-body" style="font-size: 14px"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('home') }}" class="nav-link {{ Request::is('home*') ? 'text-primary' : '' }}">Inicio</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('categorias.index') }}"
                    class="nav-link {{ Request::is('categorias*') ? 'text-primary' : '' }}">Categorías</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('subcategorias.index') }}" class="nav-link {{ Request::is('subcategorias*') ? 'text-primary' : '' }}">SubCategorías</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('inventario')}}" class="nav-link {{ Request::is('inventario*') ? 'text-primary' : '' }}">Productos</a>
            </li>
          
            <li class="nav-item d-none d-md-block">
                <a href="{{route('personal.index')}}" class="nav-link {{ Request::is('personal*') ? 'text-primary' : '' }}">Personal</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('requerimientos.index')}}" class="nav-link {{ Request::is('requerimientos*') ? 'text-primary' : '' }}">Requerimiento</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('tramites.index')}}" class="nav-link {{ Request::is('tramites*') ? 'text-primary' : '' }}">Tramites</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('solicitudes.index')}}" class="nav-link {{ Request::is('solicitudes*') ? 'text-primary' : '' }}">Solicitudes</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('asignaciones.index')}}" class="nav-link {{ Request::is('asignaciones*') ? 'text-primary' : '' }}">Asignaciones</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('productosPendientes')}}" class="nav-link {{ Request::is('productosPendientes*') ? 'text-primary' : '' }}">Devoluciones</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('entes.index')}}" class="nav-link {{ Request::is('entes*') ? 'text-primary' : '' }}">Entes</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{route('usuarios.index')}}" class="nav-link {{ Request::is('usuarios*') ? 'text-primary' : '' }}">Usuarios</a>
            </li>
          
        </ul>

        <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"> <span class="d-none d-md-inline">{{ Auth::user()->name }}
                    </span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                  
                  
                    <li class="user-footer"> <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            Salir
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li> <!--end::Menu Footer-->
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header--> <!--begin::Sidebar-->
@include('layout.script')
<script>
    // Escucha el evento 'input' en todos los campos de tipo text y textareas y convierte a mayúsculas
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona todos los inputs de tipo text y los textareas
        const textInputs = document.querySelectorAll('input[type="text"], textarea');

        // Itera sobre cada input y textarea y agrega el listener
        textInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                // Convierte el valor del input o textarea a mayúsculas
                this.value = this.value.toUpperCase();
            });
        });
    });
</script>

