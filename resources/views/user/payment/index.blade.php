@extends('layouts.user')

@section('title', 'Pagos')

@section('content')
<section class="py-3 py-lg-5">

    <div class="d-flex gap-5 align-items-center mb-5">
        <h1 class="title">Pagos</h1>
        <p class="noto-serif">Acá podes visualizar tus pagos.</p>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="mb-0 fw-medium">Pagos</h3></div>
        <div class="card-body">

            <table class="table mb-0">
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
                    @if($orders->isEmpty())
                    <tr class="empty-row">
                        <td colspan="8" class="text-muted">No elegiste ninguna membresía</td>
                    </tr>
                    @else
                        @foreach($orders as $order)
                        <tr>
                            <td>ORDEN_{{$order->id}}</td>
                            <td>
                                {{ $order->date_approved ? \Carbon\Carbon::parse($order->date_approved)->format('d/m/Y') : '----' }}
                            </td>
                            <td colspan="2">
                                @foreach($order->items as $item)
                                    <p class="mb-0">{{ $item->title }} - $ {{ number_format(($item->unit_price ?? $item->plan->price), 0, ',', '.') }}</p>
                                @endforeach
                            </td>
                            <td>{{$order->payment_id ?? '----'}}</td>
                            <td class="column-price">$ {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
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
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if($order->status == "pending")
                                        <form novalidate method="POST" action="{{route('user.payment.checkout')}}">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm">PAGAR</button>
                                        </form>
                                    @else
                                    ----
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>

</section>
@endsection

@section('scripts')
@endsection
