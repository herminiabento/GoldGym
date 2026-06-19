@extends('layouts.app')

@section('title', 'Crear nuevo plan | Admin')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-8 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="text-center px-lg-3">
                        <h1 class="title my-4">Nuevo Plan</h1>
                        <p>Agregue aquí un nuevo plan</p>
                    </div>
                    <div>
                        <form class="needs-validation" novalidate action="{{route('admin.plans.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="title" class="form-label">Título</label>
                                <input type="text" value="{{ old('title') }}" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Plan Nombre" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="form-label">Categorías</div>

                            </div>
                            <div class="row align-items-start">
                                <div class="mb-4 col-md-5">
                                    <div class="form-label">Duración</div>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input @error('duration') is-invalid @enderror" type="radio" name="duration" id="unico" value="unico" {{ old('duration') == 'unico' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="unico">x por un sólo día</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input @error('duration') is-invalid @enderror" type="radio" name="duration" id="mensual" value="mensual" {{ old('duration', 'mensual') == 'mensual' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mensual">Mensual</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('duration') is-invalid @enderror" type="radio" name="duration" id="anual" value="anual" {{ old('duration') == 'anual' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="anual">Anual</label>
                                        </div>
                                    </div>
                                    @error('duration')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4 col-md-3">
                                    <label for="price" class="form-label">Tarifa</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" value="{{ old('price') }}" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="25000" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4 col-md-3">
                                    <div class="form-label">Estado</div>
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input @error('status') is-invalid @enderror"
                                            name="status"
                                            id="status"
                                            type="checkbox"
                                            role="switch"
                                            value="1"
                                            {{ old('status', 1) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="status">Activo</label>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="image" class="form-label">Imagen</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="excerpt" class="form-label">Extracto</label>
                                <textarea class="form-control" id="excerpt" rows="3" name="excerpt"></textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" rows="6" name="description"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mb-2">
                                <a href="{{route('admin.plans.index')}}" class="btn btn-dark">Volver al listado</a>
                                <button type="submit" class="btn btn-primary">Crear plan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
