@extends('layouts.app')

@section('title', 'Ordenes de pago | Admin Dashboard')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-6 text-center">

                <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                    <div class="mb-3">
                        <div class="text-center px-lg-3">
                            <h1 class="title mb-4 mt-3 fs-2">Detalle de la orden #{{$order->id}}</h1>
                        </div>
                    </div>

                    <div>
                        <ul class="list-unstyled">
                            <li><p><span class="text-muted">Referencia:</span> ORDEN_{{$order->id}}</p></li>
                            <li>
                                <p>
                                @if($order->status == "pending" )
                                <span class="text-primary text-nowrap">
                                    <i class="bi bi-exclamation-circle-fill"></i> Pago pendiente
                                </span>
                                @endif
                                @if($order->status == "approved" )
                                <span class="text-success text-nowrap">
                                    <i class="bi bi-check-circle-fill"></i> Pago aprobado
                                </span>
                                @endif
                                @if($order->status == "rejected" )
                                <span class="text-danger text-nowrap">
                                    <i class="bi bi-x-circle-fill"></i> Pago rechazado
                                </span>
                                @endif
                                </p>
                            </li>
                            <li><p><span class="text-muted">Fecha de pago:</span> {{ $order->date_approved ? \Carbon\Carbon::parse($order->date_approved)->format('d/m/Y - H:i') : '-' }}</p></li>
                            <li><p><span class="text-muted">Nro de operación:</span> {{$order->payment_id ?? '-'}}</p></li>
                            <li><p><span class="text-muted">Total:</span> $ {{ number_format(($order->total ?? $order->total_price), 0, ',', '.') }}</p></li>
                            <li class="border border-0 border-top pt-3"><p><span class="text-muted">Usuario:</span> {{$order->user->dni}}</p></li>
                            <li><p><span class="text-muted">Nombre:</span> {{$order->user->name}} {{$order->user->lastname}}</p></li>
                            <li><p><span class="text-muted">Email:</span> <a href="mailto:{{$order->user->email}}" target="_blank">{{$order->user->email}}</a></p></li>
                            <li class="border border-0 border-top pt-3">
                                <p class="mb-0"><span class="text-muted">Items:</span></p>
                                <ul class="list-unstyled ms-5">
                                @foreach($order->items as $item)
                                    <li>{{ $item->title }} - $ {{ number_format(($item->unit_price ?? $item->plan->price), 0, ',', '.') }}</li>
                                @endforeach
                                </ul>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
