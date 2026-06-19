@extends('layouts.app')

@section('title', 'Planes | Admin')

@section('content')

<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-10 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="row mb-3">
                        <div class="col-md-4 ms-auto text-center px-lg-3">
                            <h1 class="title mb-4 mt-3">Planes</h1>
                            <p>Listado de planes</p>
                        </div>
                        <div class="text-end col-md-4 py-4">
                            <a href="{{route('admin.plans.create')}}" class="btn btn-primary">AGREGAR NUEVO PLAN</a>
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
                                    <th scope="col">Thumbnail</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Categorias</th>
                                    <th scope="col">Duración del plan</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($plans->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No hay planes cargados.</td>
                                    </tr>
                                @endif
                                @foreach($plans as $plan)
                                <tr class="align-middle {{$plan->status ? '' : 'table-warning opacity-75' }}">
                                    <td>
                                        @if($plan->image)
                                        <div class="thumbnail-img">
                                            <img src="{{asset('storage/uploads/plans/'. $plan->image) }}" alt="{{$plan->title}}" class="object-fit-cover" width="100" height="67"/>
                                        </div>
                                        @else
                                        <div class="thumbnail-img">
                                            <img src="{{asset('storage/img/planes/plan-default.jpg')}}" alt="El logo de gold gym" class="object-fit-cover" width="100" height="67"/>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$plan->title}}</td>
                                    <td>
                                        @foreach($plan->categories as $category)
                                            {{ $category->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td><span class="text-capitalize">{{$plan->duration == 'unico' ? 'x Por un sólo día' : $plan->duration}}</span></td>
                                    <td><span class="fw-bold">$ {{number_format($plan->price, 0, ',', '.')}}</span></td>
                                    <td><span class="badge {{$plan->status ? 'text-bg-success' : 'text-bg-warning' }}">{{$plan->status ? 'Activo' : 'Inactivo' }}</span></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{route('admin.plans.edit', $plan)}}" class="btn btn-sm btn-secondary">Editar</a>
                                            <a href="{{route('admin.plans.show', $plan)}}" class="btn btn-sm btn-primary">Ver</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $plans->links() }}
                        </div>
                        <div class="row">
                            <div class="ms-auto text-end col-md-4 py-4">
                                <a href="{{route('admin.plans.create')}}" class="btn btn-primary">AGREGAR NUEVO PLAN</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
