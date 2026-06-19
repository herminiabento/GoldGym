@extends('layouts.app')

@section('title', 'Categoría '.$category->name.' | Admin')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-4">
            <div class="col-lg-10 text-center">

                <div class="mb-5 px-5 text-start">
                    <div class="text-center px-lg-3 mb-5">
                        <h1 class="title my-4"><span class="fs-3 d-block text-opacity-75 text-primary mb-3">Detalle de la categoría:</span> {{$category->name}}</h1>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-evenly mb-5">
                                <p><span class="pre-title text-secondary">Código: </span>{{$category->code}}</p>
                                <p><span class="pre-title text-secondary">Nombre:</span> {{$category->name}}</p>
                            </div>
                            <div class="d-flex justify-content-evenly">
                                <a href="{{route('admin.categories.index')}}" class="btn btn-dark me-2">Ir al listado</a>
                                <a href="{{route('admin.categories.edit', $category)}}" class="btn btn-primary">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
