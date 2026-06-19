<header class="{{ Route::is('admin.*') ? 'bg-admin-header' : 'text-bg-dark' }}">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="{{route('home')}}" class="navbar-brand">Gold Gym</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarHeader">

                @if(Route::is('admin.*'))
                    @auth
                    <ul class="navbar-nav mx-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="{{route('admin.dashboard')}}" class="nav-link px-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{route('admin.orders.index')}}" class="nav-link px-2 {{ request()->is('admin/ordenes*') ? 'active' : '' }}">Ordenes</a></li>
                        <li><a href="{{route('admin.plans.index')}}" class="nav-link px-2 {{ request()->is('admin/planes*') ? 'active' : '' }}">Planes</a></li>
                        <li><a href="{{route('admin.categories.index')}}" class="nav-link px-2 {{ request()->is('admin.categorias*') ? 'active' : '' }}">Categorias</a></li>
                        <li><a href="{{route('admin.users.index')}}" class="nav-link px-2 {{ request()->is('admin/usuarios*') ? 'active' : '' }}">Usuarios</a></li>
                    </ul>
                    @endauth
                @else
                    <ul class="navbar-nav mx-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="{{route('home')}}" class="nav-link px-2 {{ request()->routeIs('home') ? 'active text-primary' : 'text-white' }}">Inicio</a></li>
                        <li><a href="{{route('about')}}" class="nav-link px-2 {{ request()->routeIs('about') ? 'active text-primary' : 'text-white' }}">El Gym</a></li>
                        <li><a href="{{route('plans')}}" class="nav-link px-2 {{ request()->routeIs('plans', 'plans.*') ? 'active text-primary' : 'text-white' }}">Planes</a></li>
                        <li><a href="{{route('contact')}}" class="nav-link px-2 {{ request()->routeIs('contact') ? 'active text-primary' : 'text-white' }}">Contacto</a></li>
                    </ul>
                    @guest
                    <div class="text-center text-lg-end">
                        <a href="{{route('auth.login')}}" class="btn btn-outline-light me-2">Ingreso</a>
                        <a href="{{route('auth.register')}}" class="btn btn-warning">Asociate</a>
                    </div>
                    @endguest
                @endif

                @auth
                <div class="me-3">Hola {{auth()->user()->name}}</div>
                <div class="text-center text-lg-end">
                     @if(Route::is('admin.*'))
                        <a href="{{route('home')}}" class="btn btn-outline-light me-2">Fontend</a>
                    @else
                        @if(auth()->user()->role->type === 'admin')
                        <a href="{{route('admin.dashboard')}}" class="btn btn-outline-light me-2">Admin</a>
                        @endif
                        @if(auth()->user()->role->type === 'user')
                        <a href="{{route('user.dashboard')}}" class="btn btn-outline-light me-2">Mi Cuenta</a>
                        @endif
                    @endif
                    <form method="POST" action="{{route('auth.logout')}}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-light me-2">Cerrar Sesión</button>
                    </form>
                </div>
                @endauth

            </div>
        </div>
    </nav>
</header>
