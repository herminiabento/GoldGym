<div class="card text-bg-dark p-3 h-100">
    <div class="card-body text-center d-flex flex-column">
        <h3 class="card-title h4 fw-semibold">{{ $plan->title }}</h3>
        <p class="h1 text-primary">$ {{ number_format($plan->price, 0, ',', '.') }}</p>
        <p class="fs-5 text-opacity-75">
            @if($plan->duration == 'unico')
                Pase válido por un sólo día
            @else
                <span class="text-capitalize">{{ $plan->duration }}</span>
            @endif
        </p>
        <p class="card-text my-auto">{{ $plan->excerpt }}</p>
    </div>
    <div class="card-footer text-center border-0">
        <a href="{{route('plans.show', $plan)}}" class="btn btn-primary">Ver Más</a>
    </div>
</div>
