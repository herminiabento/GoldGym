@extends('layouts.app')

@section('title', 'Crear nueva categoría | Admin')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-8 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="text-center px-lg-3">
                        <h1 class="title my-4">Nueva Categoría</h1>
                        <p>Agregue aquí una nueva categoría</p>
                    </div>
                    <div>
                        <form class="needs-validation" novalidate action="{{route('admin.categories.store')}}" method="POST">
                            @csrf
                            <div class="row mb-5">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label for="code" class="col-sm-2 col-form-label">Código:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="Código" required>
                                            @error('code')
                                                <div class="invalid-feedback">{{$message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label for="name" class="col-sm-3 col-form-label text-end">Nombre:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nombre" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{$message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-2">
                                <a href="{{route('admin.categories.index')}}" class="btn btn-dark mx-2">Volver al listado</a>
                                <button type="submit" class="btn btn-primary mx-2">Crear categoría</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
