@extends('layouts.user')

@section('title', 'Dashboard del usuario')

@section('content')
<section class="py-3 py-lg-5">

    <div class="mb-5">
        <h1 class="title">Mi cuenta</h1>
    </div>

    <div class="user-dashboard row pb-5">
        <div class="col-lg-6 mb-5">
            <div class="card">
                <div class="card-header"><h2 class="mb-0 fw-medium">Mis datos</h2></div>
                <div class="card-body pb-4">
                    <div class="form-user-data">
                        <div>
                            <div class="row align-items-center">
                                <div class="col-sm-4 col-form-label text-end">Usuario:</div>
                                <div class="col-sm-8">
                                    <p class="mb-0 form-control-plaintext ms-3">{{$currentUser->dni}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-form-label text-end">Nombre completo:</div>
                                <div class="col-sm-8">
                                    <p class="mb-0 form-control-plaintext ms-3">{{$currentUser->name}} {{$currentUser->lastname}}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 col-form-label text-end">Email:</div>
                                <div class="col-sm-8">
                                    <p class="mb-0 form-control-plaintext ms-3">{{$currentUser->email}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 offset-sm-4">
                                    <a href="{{route('user.profile.edit')}}" class="btn btn-secondary ms-3">EDITAR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ms-auto col-lg-6 mb-5">
            @if($currentUser->plans->isEmpty())
            <!-- Card sin plan activo -->
            <div class="card border-0 text-bg-dark p-3 pt-5">
                <div class="card-body">
                    <div class="badge-plan-active mb-0"><span class="badge text-body bg-white">Sin plan</span></div>
                    <p class="mb-4">Actualmente no estas activo en ningun plan.<br>Elegí entre los distintos planes que ofrecemos y activá tu membresía</p>
                    <div class="text-center">
                        <a href="{{route('user.membership.create')}}" class="btn btn-primary">ELEGIR Y ACTIVAR</a>
                    </div>
                </div>
            </div>
            @else
            <div class="card border-0 text-bg-dark p-3 pt-5">
                <div class="card-body d-flex flex-column">
                    <div class="badge-plan-active mb-0">
                        <h3 class="badge text-body bg-white">Membresía</h3>
                    </div>
                    <ul class="list-unstyled">
                    @foreach($currentUser->plans as $plan)
                        <li class="mb-2">
                            <p class="mb-0"><span class="h4 fw-medium">{{$plan->title}} - <span class="text-primary">$ {{number_format($plan->price, 0, '.', '.')}} /</span> <span class="fw-normal noto-serif text-white text-capitalize fs-6">{{($plan->duration == 'unico' ? 'por un sólo día' : $plan->duration)}}</span></span></p>
                            @if(!$plan->pivot->is_active)
                                @if($plan->pivot->is_valid_now)
                                    <p class="mb-0 text-warning">Este plan esta cancelado y vence el {{ \Carbon\Carbon::parse($plan->pivot->end_date)->format('d/m/Y') }}.</p>
                                @else
                                    <p class="mb-0 text-danger">Este plan no está activo, tenes que tener la cuota al día.</p>
                                @endif
                            @else
                                @if(!$plan->pivot->is_valid_now)
                                    <p class="mb-0 text-danger">Tu cuota está vencida</p>
                                @endif
                            @endif
                        </li>
                    @endforeach
                    </ul>
                    <div class="text-center">
                        <a href="{{route('user.membership.edit')}}" class="btn btn-outline-primary mx-2">CAMBIAR</a>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h2 class="mb-0 fw-medium">Última cuota</h2></div>
                <div class="card-body pb-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Fecha de pago</th>
                                <th scope="col" colspan="2">Item</th>
                                <th scope="col">Nro de Operación</th>
                                <th scope="col" class="column-price text-nowrap">Importe Total</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @if($currentUser->orders->isEmpty())
                            <tr class="empty-row">
                                <td colspan="8" class="text-muted">No elegiste ninguna membresía</td>
                            </tr>
                            @else
                                @if($lastOrder)
                                <tr>
                                    <td>ORDEN_{{$lastOrder->id}}</td>
                                    <td>
                                        {{ $lastOrder->date_approved ? \Carbon\Carbon::parse($lastOrder->date_approved)->format('d/m/Y') : '----' }}
                                    </td>
                                    <td colspan="2">
                                        @foreach($lastOrder->items as $item)
                                            <p class="mb-0">{{ $item->title }} - $ {{ number_format(($item->unit_price ?? $item->plan->price), 0, ',', '.') }}</p>
                                        @endforeach
                                    </td>
                                    <td>{{$lastOrder->payment_id ?? '----'}}</td>
                                    <td class="column-price">$ {{ number_format($lastOrder->total ?? $lastOrder->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($lastOrder->status == "pending" )
                                        <span class="text-primary text-nowrap">
                                            <i class="bi bi-exclamation-circle-fill"></i> Pago pendiente
                                        </span>
                                        @endif
                                        @if($lastOrder->status == "approved" )
                                        <span class="text-success text-nowrap">
                                            <i class="bi bi-check-circle-fill"></i> Pago aprobado
                                        </span>
                                        @endif
                                        @if($lastOrder->status == "rejected" )
                                        <span class="text-danger text-nowrap">
                                            <i class="bi bi-x-circle-fill"></i> Pago rechazado
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if($lastOrder->status == "pending")
                                                <form novalidate method="POST" action="{{route('user.payment.checkout')}}">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $lastOrder->id }}">
                                                    <button type="submit" class="btn btn-primary btn-sm">PAGAR</button>
                                                </form>
                                            @else
                                             ----
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                    <div class="text-center"><a href="{{route('user.payment.index')}}" class="btn btn-secondary">TODOS MIS PAGOS</a></div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

