@extends('layouts.app')

@section('title', 'Editar Plan '.$plan->title.' | Admin')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-8 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="text-center px-lg-3 mb-5">
                        <h1 class="title my-4"><span class="fs-3 d-block text-opacity-75 text-primary mb-3">Editando el Plan:</span> {{$plan->title}}</h1>
                    </div>
                    <div>
                        <form class="needs-validation" novalidate action="{{route('admin.plans.update', $plan)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="title" class="form-label">Título</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{old('title', $plan->title)}}" placeholder="Plan Nombre" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-label">Categorías</div>
                                <div class="d-flex flex-wrap">
                                    @foreach($categories as $category)
                                        <div class="form-check me-4">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="categories[]"
                                                value="{{ $category->id }}"
                                                id="category{{ $category->id }}"
                                                {{ in_array($category->id, $plan->categories->pluck('id')->toArray() ?? []) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="category{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('categories')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <label for="image" class="form-label">Imagen</label>
                                @if($plan->image)
                                    <div class="img">
                                        <img src="{{ asset('storage/uploads/plans/' . $plan->image) }}" alt="{{$plan->title}}" class="image-thumbnail mb-3" width="620" height="413">
                                    </div>
                                @else
                                    <div class="img">
                                        <img src="{{asset('storage/img/planes/plan-default.jpg')}}" alt="El logo de gold gym" class="image-thumbnail mb-3" width="620" height="413">
                                    </div>
                                @endif
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row align-items-center">
                                <div class="mb-4 col-md-5">
                                    <div class="form-label">Duración</div>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input @error('duration') is-invalid @enderror" type="radio" name="duration" id="unico" value="unico" {{ old('duration', $plan->duration) == 'unico' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="unico">x por un sólo día</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input @error('duration') is-invalid @enderror" type="radio" name="duration" id="mensual" value="mensual" {{ old('duration', $plan->duration) == 'mensual' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mensual">Mensual</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('duration') is-invalid @enderror" type="radio" name="duration" id="anual" value="anual" {{ old('duration', $plan->duration) == 'anual' ? 'checked' : '' }}>
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
                                        <input type="number" value="{{ old('price', $plan->price) }}" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="25000" required>
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
                                            {{ old('status', $plan->status ?? 1) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="status">Activo</label>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="excerpt" class="form-label">Extracto</label>
                                <textarea class="form-control" id="excerpt" rows="3" name="excerpt">{{old('excerpt', $plan->excerpt)}}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" rows="6" name="description">{{old('description', $plan->description)}}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#eliminarPlanModal">Eliminar Plan</button>

                                <div>
                                    <a href="{{route('admin.plans.index')}}" class="btn btn-dark">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Actualizar plan</button>
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
<!-- Modal Eliminar Plan -->
<div class="modal fade" id="eliminarPlanModal" tabindex="-1" aria-labelledby="eliminarPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="eliminarPlanModalLabel">Eliminar Plan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">¿Quiere eliminar definitivamente el plan <strong>{{$plan->title}}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Sí, eliminar plan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
