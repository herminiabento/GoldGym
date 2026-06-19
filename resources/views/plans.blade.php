@extends('layouts.app')

@section('title', 'Planes')

@section('content')
<section>
    <div id="PlanesCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('storage/img/banners/planes.jpg')}}" class="d-block w-100 h-auto" alt="Hombres en gimnasio" width="1920" height="666">
                <div class="carousel-caption text-start">
                    <div class="container">
                        <h1 class="display-1 text-uppercase">
                            <span class="d-block">Planes de <span class="text-primary ">membresía </span></span>
                            <span class="d-block">pensados para vos</span>
                        </h1>
                        <p class="h4 noto-serif fw-normal mb-5">Flexibilidad, accesibilidad y opciones para cada objetivo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5 bg-black text-white">
    <div class="container">
        <div class="row justify-content-center mb-5 py-3">
            <div class="col-xl-6 text-center">
                <div class="pre-title"><span>Planes</span></div>
                <h2 class="title">Elegí el tuyo</h2>
                <p class="text-opacity-75">Nuestras membresías son personales y corren a partir del día que realizas el pago, sin importar el día del mes que sea.</p>
            </div>
        </div>
        <div class="grid-plans mb-5">
            <!-- repite por plan -->
            @foreach($plans as $plan)
            <x-plan-card :plan="$plan"/>
            @endforeach
        </div>

    </div>
</section>

<section class="py-3 py-lg-5 d-flex align-items-center banner bg-salon text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 text-center">
                <div class="pre-title"><span>Te estamos esperando</span></div>
                <h2 class="display-2 text-uppercase">Inscribite ahora mismo</h2>
                <p class="mb-5 noto-serif fs-5">Veni a nuestro salón, conoce las instalaciones y... arrancamos!</p>
                <a href="{{route('contact')}}" class="btn btn-lg text-body btn-primary">Contactanos</a>
            </div>
        </div>
    </div>
</section>
@endsection
