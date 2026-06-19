@extends('layouts.app')

@section('title', 'Categorias | Admin Dashboard')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-8 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="mb-3">
                        <div class="text-center px-lg-3">
                            <h1 class="title mb-4 mt-3">Categorías</h1>
                            <p>Listado de categorías</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
                    @endif

                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col" class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($categories->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">No hay categorías creadas.</td>
                                    </tr>
                                @endif
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->code}}</td>
                                    <td><span class="text-capitalize">{{$category->name}}</span></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{route('admin.categories.edit', $category)}}" class="btn btn-sm mx-2 btn-secondary">Editar</a>
                                            <a href="{{route('admin.categories.show', $category)}}" class="btn btn-sm mx-2 btn-primary">Ver</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="ms-auto text-end col-md-4 py-4">
                                <a href="{{route('admin.categories.create')}}" class="btn btn-primary btn-sm">AGREGAR NUEVA CATEGORÍA</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
