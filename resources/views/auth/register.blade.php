@extends('layouts.app')

@section('title', 'Registrate')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-5 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="text-center px-lg-3">
                        <h1 class="title my-4">Registrate</h1>
                        <p>Crea un usuario para acceder a nuestro sistema.</p>
                    </div>

                    <form class="needs-validation" novalidate action="{{route('auth.register.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="number" class="form-control @error('dni') is-invalid @enderror" id="dni" placeholder="12345678" name="dni" value="{{ old('dni')}}" required>
                            @error('dni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Su número de DNI se usará como usuario para acceder al sistema.</div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nombre" name="name" value="{{ old('name')}}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Apellido</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" placeholder="Apellido" name="lastname" value="{{ old('lastname')}}" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="usuario@email.com" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="******" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">La contraseña debe tener al menos 6 caracteres alfanúmericos.</div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input @error('term') is-invalid @enderror" id="term" name="term" required>
                            <label class="form-check-label" for="term"><small>Acepto términos y condiciones</small></label>
                            @error('term')
                                <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center mb-5">
                            <button type="submit" class="btn btn-primary">Crear usuario</button>
                        </div>
                        <div class="form-text text-center">Ya tengo cuenta. <a href="{{route('auth.login')}}">Ingresar</a></div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
