@extends('layouts.app')

@section('title', 'Plan '. $plan->title)

@section('content')

<section>
    <div id="PlanesCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('storage/img/banners/planes.jpg')}}" class="d-block w-100 h-auto" alt="Hombres entrenando en el gimnasio, promoción de planes de membresía" width="1920" height="666">
                <div class="carousel-caption text-start">
                    <div class="container">
                        <h1 class="display-1 text-uppercase"><span class="d-block">Planes de <span class="text-primary ">membresía </span></span><span class="d-block">pensados para vos</span></h1>
                        <p class="h4 noto-serif fw-normal mb-5">Flexibilidad, accesibilidad y opciones para cada objetivo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">

            @if($plan->image)
            <div class="thumbnail-img">
                <img src="{{asset('storage/uploads/plans/'. $plan->image) }}" alt="{{$plan->title}}" class="object-fit-cover img-fluid" width="620" height="413"/>
            </div>
            @else
            <div class="thumbnail-img">
                <img src="{{asset('storage/img/planes/plan-default.jpg')}}" alt="El logo de gold gym" class="object-fit-cover img-fluid" width="620" height="413"/>
            </div>
            @endif

            </div>
            <div class="col-md-5 ms-auto py-3">
                <div class="pre-title">
                    @foreach($plan->categories as $category)
                        <span>{{ $category->name }}</span>@if(!$loop->last) + @endif
                    @endforeach
                </div>
                <h2 class="mb-3">{{$plan->title}}</h2>
                <div class="d-flex align-items-end mb-3">
                    <p class="display-4 h1 text-primary me-2">$ {{ number_format($plan->price, 0, ',', '.') }}</p>
                    <p class="noto-serif">/
                        @if($plan->duration == 'unico')
                            Pase para un sólo día
                        @else
                            <span class="text-capitalize">{{ $plan->duration }}</span>
                        @endif
                    </p>
                </div>
                <div class="mb-5">
                    <p>{{ $plan->description}}</p>
                </div>
                @auth
                    <a href="{{route('user.dashboard')}}" class="btn btn-primary btn-lg">¡Sumate Hoy!</a>
                @endauth
                @guest
                    <a href="{{route('auth.register')}}" class="btn btn-primary btn-lg">¡Sumate Hoy!</a>
                @endguest
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5 bg-black text-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-10 text-center">
                <div class="pre-title"><span>Planes</span></div>
                <h2 class="title">Los más elegidos</h2>
                <p class="text-opacity-75">Estas son sólo algunas de nuestras propuestas, elegí la que más este a tu medida.</p>
            </div>
        </div>
        <div class="row align-items-stretch">
            @foreach($plans as $plan)
            <div class="col-3 pb-5">
                <x-plan-card :plan="$plan"/>
            </div>
            @endforeach
        </div>
        <div class="text-center">
            <a href="{{route('plans')}}" class="btn btn-outline-light">Ver Todos los Planes</a>
        </div>
    </div>
</section>
@endsection
