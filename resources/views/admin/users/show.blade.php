@extends('layouts.app')

@section('title', 'Usuario '.$user->name.' | Admin')

@section('content')
<section class="py-3 py-lg-5">
    <div class="container">
        <div class="row justify-content-center mb-5 py-4">
            <div class="col-lg-10 text-center">

                <div class="mb-5 px-5 text-start">
                    <div class="text-center px-lg-3 mb-5">
                        <h1 class="title my-4"><span class="fs-3 d-block text-opacity-75 text-primary mb-3">Detalle del usuario:</span> {{$user->name}} </h1>
                    </div>

                    <div class="row justify-content-center mb-5">
                        <div class="col-md-6">
                            <div class="mb-5 rounded-3 px-5 py-4 border bg-white text-start">
                                <div class="text-center px-lg-3 mb-4">
                                    <h2 class="h3 my-2">Datos personales</h2>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-end">
                                        <p class="col-form-label"><span class="pre-title text-secondary">DNI: </span></p>
                                    </div>
                                    <div class="col-sm-7">
                                        <p class="col-form-label mb-0">{{$user->dni}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-end">
                                        <p class="col-form-label"><span class="pre-title text-secondary">Nombre completo: </span></p>
                                    </div>
                                    <div class="col-sm-7">
                                        <p class="col-form-label mb-0">{{$user->name}} {{$user->lastname}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-end">
                                        <p class="col-form-label"><span class="pre-title text-secondary">Email: </span></p>
                                    </div>
                                    <div class="col-sm-7">
                                        <p class="col-form-label mb-0"><a href="mailto:{{$user->email}}" target="_blank">{{$user->email}}</a></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-end">
                                        <p class="col-form-label"><span class="pre-title text-secondary">Tipo de usuario: </span></p>
                                    </div>
                                    <div class="col-sm-7">
                                        <p class="col-form-label mb-0 text-capitalize">{{$user->role->name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($user->role->type === 'user')
                        <div class="col-md-6">
                            <div class="mb-5 rounded-3 px-3 py-4 border bg-white text-start">
                                <div class="text-center px-lg-3 mb-4">
                                    <h2 class="h3 my-2">Membresía</h2>
                                </div>
                                @if($user->plans->isEmpty())
                                <p class="mb-0">No tiene ninguna membresía</p>
                                @else
                                <table class="table mb-3">
                                    <thead>
                                        <tr>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Tarifa</th>
                                        <th scope="col">Abono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->plans as $plan)
                                        <tr>
                                            <th scope="row">{{$plan->title}}</th>
                                            <td>$ {{number_format($plan->price, 0, ',', '.')}}</td>
                                            <td><span class="text-capitalize">{{$plan->duration}}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tr>
                                        <th>Total: </th>
                                        <td colspan="2"><span class="text-capitalize fw-bold">$ {{number_format($totalPrice, 0, ',', '.')}}</span></td>
                                    </tr>
                                </table>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    @if ($user->role->type === 'user')
                    <div class="mb-5 rounded-3 px-3 py-4 border bg-white text-start">
                        <div class="text-center px-lg-3 mb-4">
                            <h2 class="h3 my-2">Pagos</h2>
                        </div>
                        <div class="">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>Fecha de pago</th>
                                        <th scope="col" colspan="2">Item</th>
                                        <th scope="col">Nro de Operación</th>
                                        <th scope="col" class="column-price text-nowrap">Importe Total</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    @if($orders->isEmpty())
                                    <tr class="empty-row">
                                        <td colspan="7" class="text-muted">No hizo ningun pago</td>
                                    </tr>
                                    @else
                                        @foreach($orders as $order)
                                        <tr>
                                            <td>ORDEN_{{$order->id}}</td>
                                            <td>
                                                {{ $order->date_approved ? \Carbon\Carbon::parse($order->date_approved)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td colspan="2">
                                                @foreach($order->items as $item)
                                                    <p class="mb-0">{{ $item->title }} - $ {{ number_format(($item->unit_price ?? $item->plan->price), 0, ',', '.') }}</p>
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
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $orders->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-evenly">
                                <a href="{{route('admin.users.index')}}" class="btn btn-dark me-2">Ir al listado</a>
                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-primary">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
