@extends('layouts.app')

@section('title', 'Ordenes de pago | Admin Dashboard')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-5">
            <div class="col-lg-12 text-center">

                <div class="mb-5 rounded-3 px-3 py-4 border bg-white text-start">
                    <div class="mb-3">
                        <div class="text-center px-lg-3">
                            <h1 class="title mb-4 mt-3">Ordenes de pago</h1>
                            <p>Listado de las ordenes de pagos de los socios</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
                    @endif

                    <div class="filtros text-end">
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
                            @csrf
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <label class="form-label mb-0" for="status">Filtrar por: </label>
                                <select name="status" class="form-select d-inline-block w-auto">
                                    <option value="">Todos los pagos</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                                        Aprobado
                                    </option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                                        Rechazado
                                    </option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                </select>

                                <button class="btn btn-secondary">
                                    Filtrar
                                </button>
                            </div>
                        </form>
                    </div>


                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha de pago</th>
                                <th scope="col">Usuario</th>
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
                                <td colspan="9" class="text-muted">No hizo ningun pago</td>
                            </tr>
                            @else
                                @foreach($orders as $order)
                                <tr>
                                    <td>ORDEN_{{$order->id}}</td>
                                    <td>
                                        {{ $order->date_approved ? \Carbon\Carbon::parse($order->date_approved)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{$order->user->name}} {{$order->user->lastname}}</td>
                                    <td colspan="2">
                                        @foreach($order->items as $item)
                                            <p class="mb-0">{{ $item->title }}</p>
                                        @endforeach
                                    </td>
                                    <td>{{$order->payment_id ?? '-'}}</td>
                                    <td class="column-price">$ {{ number_format(($order->total ?? $order->total_price), 0, ',', '.') }}</td>
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
                                        <a href="{{route('admin.users.show', $order->user_id)}}" class="btn btn-sm mx-2 btn-secondary">Ver usuario</a>
                                        <a href="{{route('admin.orders.show', $order->id)}}" class="btn btn-sm mx-2 btn-primary">Ver más</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div>
                        {{ $orders->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
