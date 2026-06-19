@extends('layouts.user')

@section('title', 'Editar plan de membresía')

@section('content')
<section class="py-3 py-lg-5">
    <div class="d-flex gap-5 align-items-center mb-5">
        <h1 class="title">Mi membresía</h1>
        <p class="noto-serif">Podés elegír un plan o combinarlos a tu gusto.<br>Activás y ¡empezamos a entrenar juntos! *</p>
    </div>

    <div class="user-dashboard row pb-5">
        <div class="col-lg-8 order-lg-last">
            <!-- Card con plan actual -->
            <div class="card border-0 text-bg-dark pt-5" id="current-plan">
                <div class="card-body">
                    <div class="badge-plan-active mb-0">
                        <span class="badge text-body bg-white">
                        @if($currentUser->plans->isEmpty())
                            Sin plan
                        @else
                            Membresía
                        @endif
                        </span>
                    </div>

                    @if($currentUser->plans->isEmpty())
                    <!-- Card sin plan activo -->
                        <p class="mb-4">Actualmente no estas activo en ningun plan.<br>Elegí entre los distintos planes que ofrecemos y activá tu membresía</p>
                        <div class="text-center mb-3">
                            <a href="{{route('user.membership.create')}}" class="btn btn-primary">ELEGIR Y ACTIVAR</a>
                        </div>
                    @else
                        <ul class="list-unstyled">
                        @foreach($currentUser->plans as $plan)
                            <li class="mb-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="h5 mb-0 fw-medium">{{$plan->title}}</div>
                                            <div>
                                                <p class="mb-0 ms-auto">
                                                    <span class="text-primary h5 fw-medium">$ {{number_format($plan->price, 0, '.', '.')}} /</span>
                                                    <span class="fw-normal noto-serif text-white text-capitalize small">{{($plan->duration == 'unico' ? 'por un sólo día' : $plan->duration)}}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        @if(!$plan->pivot->is_valid_now)
                                        @if($hasPendingOrderForExpiredPlans)
                                            <a href="{{ route('user.payment.index') }}" class="btn btn-primary btn-sm">PAGAR</a>
                                        @else
                                        <form novalidate method="POST" action="{{route('user.membership.update')}}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="plans[]" value="{{ $plan->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm">PAGAR</button>
                                        </form>
                                        @endif
                                        @endif
                                        @if($plan->pivot->is_active)
                                        <button class="btn btn-danger btn-sm"
                                            type="button"
                                            data-plan-id="{{ $plan->id }}"
                                            data-plan-name="{{ $plan->title }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#cancelarMembresiaModal"
                                        >CANCELAR</button>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        @if($plan->pivot->is_active)
                                            @if($plan->pivot->is_valid_now)
                                                <p class="small mb-0 text-success-subtle">Vence el {{ \Carbon\Carbon::parse($plan->pivot->end_date)->format('d/m/Y') }}</p>
                                            @else
                                                <p class="small mb-0 text-danger">Tu cuota está vencida</p>
                                            @endif
                                        @else
                                            @if($plan->pivot->is_valid_now)
                                                <p class="small mb-0 text-warning">Este plan esta cancelado <br/>y vence el {{ \Carbon\Carbon::parse($plan->pivot->end_date)->format('d/m/Y') }}</p>
                                            @else
                                                <p class="small mb-0 text-danger">Este plan no está activo,<br/>tenes que tener la cuota al día.</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                        <div class="text-end border-top pt-3 mb-4">
                            <p class="mb-0 h5 fw-normal"><span> Total:</span> $ {{number_format($totalPrice ?? 0, 0, ',', '.')}}</p>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{route('user.membership.edit')}}" class="btn btn-outline-primary">CAMBIAR</a>
                        </div>

                    @endif
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('modals')
<div class="modal fade" id="cancelarMembresiaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="eliminarCatLabel">Membresía del Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-cancelar-membresia" method="POST" action="{{ route('user.membership.cancel') }}" class="d-inline">
            @csrf
            <input type="hidden" name="plans[]" id="plan-id-input">
                <div class="modal-body">
                    <p class="mb-0">¿Querés cancelar <strong id="plan-name-text"></strong> de tú membresía?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button class="btn btn-outline-danger" type="submit">Sí, cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var cancelarModal = document.getElementById('cancelarMembresiaModal');

    cancelarModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var planId = button.getAttribute('data-plan-id');
        var planName = button.getAttribute('data-plan-name');

        var input = cancelarModal.querySelector('#plan-id-input');
        input.value = planId;

        var planText = cancelarModal.querySelector('#plan-name-text');
        planText.textContent = planName;
    });
});
</script>

@endsection

