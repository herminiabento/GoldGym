@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-5 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <h1 class="title my-4 text-center">Login</h1>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form class="needs-validation" novalidate action="{{route('auth.login.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="dni" class="form-label">Usuario</label>
                            <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" required>
                            @error('dni')
                                <div class="invalid-feedback d-block">Error en el usuario.</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback d-block">Error en la contraseña.</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('rememberMe') is-invalid @enderror" type="checkbox" value="" name="rememberMe" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Recordarme
                                </label>
                            </div>
                            @error('rememberMe')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center mb-5">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>
                        <div class="form-text text-center">¿No tenes una cuenta?. <a href="{{route('auth.register')}}">Registrate</a></div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
