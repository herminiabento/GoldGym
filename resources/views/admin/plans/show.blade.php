@extends('layouts.app')

@section('title', 'Plan '.$plan->title.' | Admin')

@section('content')

<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-4">
            <div class="col-lg-10 text-center">

                <div class="mb-5 px-5 text-start">
                    <div class="text-center px-lg-3 mb-5">
                        <h1 class="title my-4"><span class="fs-3 d-block text-opacity-75 text-primary mb-3">Detalle del Plan:</span> {{$plan->title}}</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            @if($plan->image)
                            <div class="plan-img">
                                <img src="{{asset('storage/uploads/plans/'. $plan->image) }}" alt="{{$plan->title}}" class="object-fit-cover img-fluid" width="620" height="413"/>
                            </div>
                            @else
                            <div class="plan-img">
                                <img src="{{asset('storage/img/planes/plan-default.jpg')}}" alt="El logo de gold gym" class="object-fit-cover img-fluid" width="620" height="413"/>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 offset-md-1">
                            <p>
                                <span class="pre-title text-secondary">Estado: </span>
                                @if($plan->status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-warning">Inactivo</span>
                                @endif
                            </p>
                            <p><span class="pre-title text-secondary">Categorías:</span> <span>Musculación</span> - <span>Pilates</span></p>
                            <p><span class="pre-title text-secondary">Tarifa: </span> <span class="h3 text-primary me-2"> $ {{number_format($plan->price, 0, ',', '.')}}</span></p>
                            <p><span class="pre-title text-secondary">Periodicidad:</span> <span class="text-capitalize">{{$plan->duration}}</span></p>
                            <p>
                                <span class="pre-title text-secondary">Extracto:</span>
                                @if($plan->excerpt)
                                    {{$plan->excerpt}}
                                @else
                                    <span class="text-danger">No se ingresó ninguna reseña</span>
                                @endif
                            </p>
                            <p class="mb-0"><span class="pre-title text-secondary">Descripción:</span></p>
                            <div class="mb-5">
                                @if($plan->description)
                                    {!! nl2br(e($plan->description)) !!}
                                @else
                                    <span class="text-danger">No se ingresó ninguna descripción</span>
                                @endif
                            </div>
                            <div class="d-flex">
                                <a href="{{route('admin.plans.index')}}" class="btn btn-dark me-2">Ir a Planes</a>
                                <a href="{{route('admin.plans.edit', $plan)}}" class="btn btn-primary">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
