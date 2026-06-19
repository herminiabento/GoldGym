@extends('layouts.user')

@section('title', 'Mis Datos')

@section('content')
<section class="py-3 py-lg-5">

    <div class="d-flex gap-5 align-items-center mb-5">
        <h1 class="title">Mi perfil</h1>
    </div>

    <div class="row pb-5">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header"><h2 class="mb-0 fw-medium">Mis datos</h2></div>
                <div class="card-body pb-4">
                    <div class="form-user-data">
                        <form id="f-user-data" novalidate method="POST" action="{{route('user.profile.update')}}">
                            @csrf
                            @method('PUT')
                            <div class="row align-items-center">
                                <div class="col-sm-4 col-form-label text-end">Usuario:</div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control-plaintext" value="{{ $currentUser->dni }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Nombre:</label>
                                <div class="col-sm-8">
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $currentUser->name) }}"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Apellido:</label>
                                <div class="col-sm-8">
                                    <input
                                        type="text"
                                        name="lastname"
                                        class="form-control @error('lastname') is-invalid @enderror"
                                        value="{{ old('lastname', $currentUser->lastname) }}"
                                        required
                                    >
                                    @error('lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Email:</label>
                                <div class="col-sm-8">
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $currentUser->email) }}"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="mb-3 h4">Cambiar contraseña</div>
                            <p>Si no desea cambiar su contraseña puede dejar estos campos en blanco.</p>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Contraseña actual:</label>
                                <div class="col-sm-8">
                                    <input
                                        type="password"
                                        name="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        required
                                    >
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Nueva contraseña:</label>
                                <div class="col-sm-8">
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        required
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-end">Confirmar contraseña:</label>
                                <div class="col-sm-8">
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">
                                        GUARDAR CAMBIOS
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
