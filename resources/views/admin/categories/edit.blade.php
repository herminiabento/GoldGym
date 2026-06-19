@extends('layouts.app')

@section('title', 'Editar categoría '.$category->name.' | Admin')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-8 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="text-center px-lg-3 mb-5">
                        <h1 class="title my-4"><span class="fs-3 d-block text-opacity-75 text-primary mb-3">Editando la categoría:</span> {{$category->name}}</h1>
                    </div>
                    <div>
                        <form class="needs-validation" novalidate action="{{route('admin.categories.update', $category)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-5">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label for="code" class="col-sm-2 col-form-label">Código:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $category->code) }}" placeholder="Código" required>
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
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Nombre" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{$message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#eliminarCatModal">Eliminar categoría</button>
                                <div>
                                    <a href="{{route('admin.categories.index')}}" class="btn btn-dark">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Actualizar categoría</button>
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

@section('modals')
<!-- Modal Eliminar Categoría -->
<div class="modal fade" id="eliminarCatModal" tabindex="-1" aria-labelledby="eliminarCatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="eliminarCatModalLabel">Eliminar Categoría</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Quiere eliminar definitivamente el plan <strong>{{$category->name}}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Sí, eliminar categoría</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
