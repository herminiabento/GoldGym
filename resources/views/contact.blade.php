@extends('layouts.app')

@section('title', 'Nosotros')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-8 text-center">
                <h1 class="title">Contacto</h1>
                <p>Estamos para ayudarte.<br>Si tenés dudas, querés conocer nuestros planes o agendar una clase, escribinos o pasá por el gimnasio. <span class="d-block">Te esperamos para empezar juntos tu entrenamiento.</span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 me-auto">
                <div class="pre-title"><span>Donde estamos</span></div>
                <h2 class="mb-3">Conocé nuestro gimnasio</h2>
                <p>Comunicate o visitanos para cualquier consulta, estamos a disposición.</p>
                <ul class="mb-5">
                    <li class="mb-3"><a href="https://maps.app.goo.gl/XuFbrZj96foKf5dF7" target="_blank">Av. Nicolas Avellaneda 1483 - Aldea Brasilera</a></li>
                    <li class="mb-3"><a href="https://wa.link/yva8n8" target="_blank">3435079909</a></li>
                    <li>Lunes a Viernes - 8:00 a 20:00hs</li>
                </ul>
                <a class="btn btn-primary mt-3" href="{{route('about')}}">¿Querés saber más de nosotros?</a>
            </div>

            <div class="col-md-6 pt-5">
                <div class="mb-5 rounded-3 p-5 text-bg-light border">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d852.4108359759877!2d-60.585567938008666!3d-31.89059779981581!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b5b5006a9ec153%3A0x222277d779c69f2a!2sGold%20Gym!5e1!3m2!1ses!2sar!4v1756792487948!5m2!1ses!2sar" width="600" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
