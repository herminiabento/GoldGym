@extends('layouts.user')

@section('title', 'Editar plan de membresía')

@section('content')
<section class="py-3 py-lg-5">
    <div class="d-flex gap-5 align-items-center mb-5">
        <h1 class="title">Mi membresía</h1>
        <p class="noto-serif">Podés elegír un plan o combinarlos a tu gusto.<br>Activás, pagas y ¡empezamos a entrenar juntos! *</p>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="mb-0 fw-medium">Nuestros Planes</h3></div>
        <div class="card-body">
            <form novalidate method="POST" action="{{route('user.membership.update')}}">
                @csrf
                @method('PUT')
                <div class="row mb-5">

                    @foreach($plansGrouped as $categoryName => $plans)
                    <div class="col-lg-12">
                        <h4 class="mb-1">{{ $categoryName }}</h4>
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="col-md-4 py-2 mb-3">
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            name="plans[]"
                                            value="{{ $plan->id }}"
                                            id="plan_{{ $plan->id }}"
                                            class="form-check-input plan-checkbox"
                                            data-title="{{ $plan->title }}"
                                            data-duration="{{ $plan->duration }}"
                                            data-price="{{ $plan->price }}"
                                            {{ in_array($plan->id, old('plans', $currentUser->plans->pluck('id')->toArray())) ? 'checked' : '' }}
                                        />
                                        <label class="form-check-label" for="plan_{{ $plan->id }}">
                                            {{ $plan->title }} <br>
                                            <span class="text-nowrap">$ {{ number_format($plan->price, 0, ',', '.') }} / <span class="text-muted small fst-italic">{{ $plan->duration }}</span></span>
                                        </label>
                                        <p class="small text-muted mb-0 border-0 pt-1 mt-1 border-top">{{$plan->description}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach


                    @if($multiCategoryPlans->count())
                    <div class="col-lg-12">
                        <h4 class="mb-1">Planes Mixtos</h4>
                        <div class="row">
                        @foreach($multiCategoryPlans as $plan)
                            <div class="col-md-4 py-2 mb-3">
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        name="plans[]"
                                        value="{{ $plan->id }}"
                                        id="plan_{{ $plan->id }}"
                                        class="form-check-input plan-checkbox"
                                        data-title="{{ $plan->title }}"
                                        data-duration="{{ $plan->duration }}"
                                        data-price="{{ $plan->price }}"
                                        {{ in_array($plan->id, old('plans', $currentUser->plans->pluck('id')->toArray())) ? 'checked' : '' }}
                                    />
                                    <label class="form-check-label" for="plan_{{ $plan->id }}">
                                        {{ $plan->title }} <br/> <span class="text-nowrap">$ {{ number_format($plan->price, 0, ',', '.') }} / <span class="text-muted small fst-italic">{{ $plan->duration == 'unico' ? 'por un sólo día' : $plan->duration }}</span></span>
                                    </label>
                                    <p class="small text-muted mb-0 border-0 pt-1 mt-1 border-top">
                                        Incluye: {{ implode(', ', $plan->categories->pluck('name')->toArray()) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                        <h4>Resumen de membresía</h4>
                    </div>
                    <div class="col-lg-8 offset-lg-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Tipo de abono</th>
                                    <th scope="col" class="column-price">Importe</th>
                                </tr>
                            </thead>
                            <tbody id="summary-body">
                                <tr class="empty-row">
                                    <td colspan="3" class="text-muted">No hay planes seleccionados</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table fw-medium fs-5">
                            <tbody>
                                <tr>
                                    <td class="text-end pe-4">Subtotal</td>
                                    <td id="subtotal" class="column-price">$0</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-end pe-4">Total</td>
                                    <td id="total" class="column-price">$0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12">
                        <div class="text-end mb-4">
                            <a href="{{url()->previous()}}" class="btn btn-secondary me-3">VOLVER</a>
                            <button type="submit" class="btn btn-primary">ACTIVAR</button>
                        </div>
                    </div>
                </div>
                <div class="form-text">* Los cambios se haran efectivo una vez confirmado el pago.</div>
            </form>
        </div>
    </div>
</section>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkboxes = document.querySelectorAll('.plan-checkbox');
    const tableBody = document.getElementById('summary-body');
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total');

    function updateSummary() {
        tableBody.innerHTML = '';
        let subtotal = 0;

        const checked = document.querySelectorAll('.plan-checkbox:checked');

        if (checked.length === 0) {
            tableBody.innerHTML = `
                <tr class="empty-row">
                    <td colspan="3" class="text-muted">No hay planes seleccionados</td>
                </tr>
            `;
            subtotalEl.textContent = "$0";
            totalEl.textContent = "$0";
            return;
        }

        checked.forEach(chk => {
            const title = chk.dataset.title;
            const duration = chk.dataset.duration;
            const price = parseInt(chk.dataset.price);

            subtotal += price;

            tableBody.innerHTML += `
                <tr>
                    <td>${title}</td>
                    <td>${duration}</td>
                    <td class="column-price">$${price.toLocaleString('es-AR')}</td>
                </tr>
            `;
        });

        subtotalEl.textContent = "$" + subtotal.toLocaleString('es-AR');
        totalEl.textContent = "$" + subtotal.toLocaleString('es-AR');
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateSummary);
    });

    updateSummary();
});
</script>

@endsection

