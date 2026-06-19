@extends('layouts.app')

@section('title', 'Bienvenidos')

@section('content')
<section>
    <div id="homeCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('storage/img/banners/home.jpg')}}" class="d-block w-100 h-auto" alt="Hombre corriendo en cinta" width="1920" height="831">
                <div class="carousel-caption text-start">
                    <div class="container">
                        <h1 class="display-1 text-uppercase"><span class="d-block">La disciplina </span><span class="d-block">es el puente entre </span><span class="text-primary d-block">tus metas y tus logros</span></h1>
                        <p class="h4 noto-serif fw-normal mb-5">Entrená con nosotros y empezá a transformar tu cuerpo.</p>
                        <a class="btn btn-lg btn-primary text-black" href="{{route('auth.register')}}">¡Sumate Hoy!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 p-3">
            <div class="col-8 text-center">
                <div class="pre-title"><span>Actividades</span></div>
                <h2 class="title">Elegí tu forma de moverte</h2>
                <p>Ya sea que busques fuerza, equilibrio o energía, tenemos una actividad para vos.<br>Entrenamientos con máquinas, clases dinámicas y profesionales que te acompañan en cada paso.<br>Elegí tu forma de moverte, y empezá a sentirte mejor.</p>
            </div>
        </div>
        <div class="row align-items-stretch">
            <div class="col-lg-4">
                <div class="card h-100 border-0 card-home-hover bg-primary p-3">
                    <img src="{{asset('storage/img/iconos/musculacion.png')}}" class="mx-auto mt-3" alt="brazo con pesa" width="82" height="82">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">Musculación</h3>
                        <p class="card-text">Sala de musculación equipada con <strong> modernas máquinas, pesos libres, mancuernas</strong>, y todo lo que necesitás para trabajar fuerza, resistencia y tono muscular. Acompañado por profesores.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 card-home-hover bg-primary p-3">
                    <img src="{{asset('storage/img/iconos/reformador.png')}}" class="mx-auto mt-3" alt="reformer" width="82" height="82">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">Pilates</h3>
                        <p class="card-text">Tonificá, mejorá tu postura y ganá flexibilidad con el preciso del <strong>Reformer</strong>. Clases personalizadas, guiadas por profesionales y adaptadas a todos los niveles.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 card-home-hover bg-primary p-3">
                    <img src="{{asset('storage/img/iconos/strong.png')}}" class="mx-auto mt-3" alt="personas haciendo gimnasia" width="82" height="82">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">Fitness</h3>
                        <p class="card-text">Movete, divertite y ponete en forma con nuestras clases de <strong> Zumba y Strong</strong>. Cardio, ritmo y fuerza en entrenamientos dinámicos, motivadores.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5">
    <div class="container pt-3 pt-lg-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{asset('storage/img/pilates-reformer-naranja.jpg')}}" alt="Chica haciendo pilates en reformer" class="img-fluid" width="620" height="470">
            </div>
            <div class="col-md-5 ms-auto py-3">
                <div class="pre-title"><span>Nuestro espacio</span></div>
                <h2 class="mb-3">Nuestro gimnasio</h2>
                <p>Contamos con un salón amplio, cómodo y equipado con todo lo que necesitás para entrenar garantizando un entorno seguro, funcional y orientado a resultados.</p>
                <ul>
                    <li class="mb-2">Equipamiento de musculación y cardio de nivel profesional</li>
                    <li class="mb-2">Espacio para clases dirigidas</li>
                    <li class="mb-2">Sector de Pilates Reformer</li>
                    <li class="mb-2">Ambiente climatizado</li>
                    <li>Supervisión permanente por parte de instructores calificados</li>
                </ul>
                <a class="btn btn-primary mt-3" href="{{route('contact')}}">Vamos al Gym</a>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5">
    <div class="container pb-3 pb-lg-5">
        <div class="row flex-row-reverse">
            <div class="col-md-6">
                <img src="{{asset('storage/img/musculacion-mancuernas.jpg')}}" alt="hombre con mancuernas" class="img-fluid" width="620" height="413">
            </div>
            <div class="col-md-5 me-auto">
                <div class="pre-title"><span>Membresías</span></div>
                <h2 class="mb-3">Accesibilidad y opciones para cada objetivo</h2>
                <p>Ofrecemos distintos tipos de membresías para adaptarnos a tus necesidades, horarios y forma de entrenar.</p>
                <p>Planes mensuales, por clase, combinados o ilimitados, con acceso a musculación, Pilates Reformer, clases de fitness y más.</p>
                <p>Elegí la modalidad que mejor se ajuste a tu rutina y empezá a entrenar con el respaldo de un equipo profesional y un espacio equipado para tu progreso.</p>
                <a class="btn btn-primary mt-3" href="{{route('plans')}}">Ver Planes</a>
            </div>
        </div>
    </div>
</section>

<section class="py-3 py-lg-5 bg-black text-white">
    <div class="container">
        <div class="row justify-content-center mb-5 py-3">
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
            <a href="{{route('plans')}}" class="btn btn-outline-light bn-lg">Ver Todos los Planes</a>
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
