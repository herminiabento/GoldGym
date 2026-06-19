@extends('layouts.app')

@section('title', 'Nosotros')


@section('content')
<section>
    <div id="nosotrosCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('storage/img/banners/el-gym.jpg') }}" class="d-block w-100 h-auto" alt="Mujeres haciendo pilates" width="1920" height="666">
                <div class="carousel-caption text-start">
                    <div class="container">
                        <h1 class="display-2 text-uppercase">
                            <span class="d-block"><span class="text-primary">Bienestar</span> no es solo físico,</span>
                            <span class="d-block">es mental y emocional.</span>
                            <span class="d-block">Aquí lo entrenamos todo.</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5">
    <div class="container pt-3 pt-lg-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{asset('storage/img/pilates-reformer.jpg')}}" alt="Chica haciendo pilates en reformer" class="img-fluid" width="620" height="470">
            </div>
            <div class="col-md-5 ms-auto py-3">
                <div class="pre-title"><span>Día a día</span></div>
                <h2 class="mb-3">Misión</h2>
                <p>En <span class="anton-regular">Gold Gym</span> trabajamos cada día para ofrecer un espacio accesible, inclusivo y motivador, donde personas de todas las edades y niveles puedan mejorar su salud física, mental y emocional.</p>
                <p>Nuestro compromiso es guiar a cada cliente hacia su mejor versión, a través de programas de entrenamiento efectivos, atención personalizada y un ambiente de comunidad y bienestar.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5">
    <div class="container pb-3 pb-lg-5">
        <div class="row flex-row-reverse align-items-center">
            <div class="col-md-6">
                <img src="{{asset('storage/img/hombre-fitness.jpg')}}" alt="hombre con mancuernas" class="img-fluid" width="620" height="413">
            </div>
            <div class="col-md-5 me-auto">
                <h2 class="mb-3">Visión</h2>
                <p>Ser el gimnasio de referencia en la región por promover un estilo de vida saludable y equilibrado para todos.</p>
                <p>En <span class="anton-regular">Gold Gym</span> aspiramos a construir una comunidad fuerte, activa y consciente, donde el bienestar no sea solo una meta, sino un estilo de vida que inspire a más personas cada día.</p>
            </div>
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
