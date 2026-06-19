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
            <div class="row">
                <div class="col-12">
                    <h4>Resumen de pago</h4>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Descripción</th>
                                <th scope="col" class="column-price">Importe</th>
                            </tr>
                        </thead>
                        <tbody id="summary-body">

                            @if(empty($preference->items))
                            <tr class="empty-row">
                                <td colspan="3" class="text-muted">No hay planes seleccionados</td>
                            </tr>
                            @else
                                @foreach($preference->items as $item)
                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->description}}</td>
                                    <td class="column-price">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-end pe-4">Total</td>
                                <td id="total" class="column-price">${{number_format($total, 0, ',', '.')}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <div class="text-end mb-4">
                                        <div id="wallet_container" class="d-inline-block"></div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>

  // Inicializa o SDK do Mercado Pago
  const mp = new MercadoPago("{{env('MERCADO_PAGO_PUBLIC_KEY')}}",{locale: "es-AR"});

  // Cria o botão de pagamento
  const bricksBuilder = mp.bricks();
  const renderWalletBrick = async (bricksBuilder) => {
    await bricksBuilder.create("wallet", "wallet_container", {
      initialization: {
        preferenceId: "{{$preference->id}}",
        redirectMode: 'self'
      },
      customization: {
        text: {
            action: "pay",
            valueProp: "security_safety"
        }
      }
    });
  };

  renderWalletBrick(bricksBuilder);
</script>
@endsection
