<div class="sidebar col-md-3 col-lg-2 pt-5 border border-end border-0">
    <div class="fs-3 anton-regular mb-2">Mi cuenta</div>
    <nav>
        <ul class="nav navbar-user flex-column">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 rounded {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{route('user.dashboard')}}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 rounded {{ request()->is('user/membresia*') ? 'active' : '' }}" href="{{route('user.membership.index')}}">Membresía</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 rounded {{ request()->is('user/pagos*') ? 'active' : '' }}" href="{{route('user.payment.index')}}">Pagos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 rounded {{ request()->is('user/perfil*') ? 'active' : '' }}" href="{{route('user.profile.edit')}}">Mi perfil</a>
            </li>
        </ul>
    </nav>
</div>
