<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Plan;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Preference;
use MercadoPago\Client\Payment\PaymentClient;
use Carbon\Carbon;

class PaymentController extends Controller
{
    //
    public function index()
    {
        $currentUser = Auth::user();
        $inactivePlans = $currentUser->plans->where('pivot.is_active', 0);

        $orders = $currentUser->orders()->orderBy('created_at', 'desc')->with([
            'items' => function ($q) {
                $q->whereHas('plan', function ($p) {
                    $p->where('status', 1);
                });
            },
            'items.plan'])->get();

        foreach ($orders as $order) {
            $order->total_price = $order->items->sum(fn($item) => $item->plan->price);
        }

        return view('user.payment.index', compact('inactivePlans','orders'));
    }

    public function checkout(Request $request){

        $currentUser = Auth::user();

        $order = Order::with('items.plan')->find($request->order_id);

        if (!$order) {
            return redirect()->route('user.payment.index')->with('error', 'No existe la orden');
        }

        $mpItems = $order->items->map(function ($item) {
            return [
                "id" => $item->id,
                "title" => $item->plan->title,
                "description" => $item->plan->description,
                "quantity" => $item->quantity,
                "unit_price" => (float) $item->plan->price
            ];
        })->toArray();

        // Datos para el checkout de MercadoPago
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        $client = new PreferenceClient();

        $preference = $client->create([
            "items" => $mpItems,
            "back_urls" => [
                // "success" => route('user.payment.success', ['message' => 'El pago se realizó correctamente']),
                "success" => "https://davinci.edu.ar/",
                "failure" => "https://davinci.edu.ar/",
                "pending" => "https://davinci.edu.ar/"
            ],
            "auto_return" => "approved",
            "statement_descriptor" => "Gold Gym",
            "external_reference" => "ORDEN_". $order->id
        ]);

        $order->update([
            'preference_id' => $preference->id
        ]);
        $total = array_sum(array_map(fn($i) => $i['quantity'] * $i['unit_price'], $mpItems));

        return view('user.payment.checkout', compact('preference', 'order', 'total'));

    }


    public function success(Request $request)
    {

        $reference = $request->query('external_reference');
        $paymentId = $request->query('payment_id');
        $orderId = (int) str_replace('ORDEN_', '', $reference);

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'No existe la orden');
        }

        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        // Obtengo los datos del pago con la API de Mercado Pago
        $paymentClient = new PaymentClient();
        $payment = $paymentClient->get($paymentId);

        //dd($payment);
        $startDate = Carbon::parse($payment->date_approved)->startOfDay();

        if ($payment->status === "approved") {
            $order->update([
                'total' => $payment->transaction_amount,
                'status' => $request->query('status'),   // approved / pending / rejected
                'payment_id' => $request->query('payment_id'),
                'preference_id' => $request->query('preference_id'),
                'date_approved' => $request->query('status') === 'approved' ? $startDate : null,
            ]);

            if (!empty($payment->additional_info->items)) {
                foreach ($payment->additional_info->items as $mpItem) {
                    $item = $order->items()->find($mpItem->id);
                    if ($item) {
                        $item->update([
                            'unit_price' => $mpItem->unit_price
                        ]);
                    }
                }
            }

            // actualizo el estado de los planes del usuario
            $user = $order->user;

            foreach ($order->items as $item) {
                $endDate = $item->plan->calculateEndDate($startDate);

                $user->plans()->syncWithoutDetaching([
                    $item->plan_id => [
                        'is_active'  => true,
                        'start_date' => $startDate->toDateString(),
                        'end_date'   => $endDate?->toDateString()
                    ]
                ]);
            }

            return view('user.payment.success', compact('payment', 'order'));
        }

        return redirect()->route('user.payment.failure')->with('error', 'Hubo un problema con el pago.');
    }

    public function failure(Request $request)
    {
        $reference = $request->query('external_reference');
        $paymentId = $request->query('payment_id');
        $orderId = (int) str_replace('ORDEN_', '', $reference);

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'No existe la orden');
        }

        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        // Obtengo los datos del pago con la API de Mercado Pago
        $paymentClient = new PaymentClient();
        $payment = $paymentClient->get($paymentId);

        //dd($payment);
        $startDate = Carbon::parse($payment->date_approved)->startOfDay();

        $order->update([
            'total' => $payment->transaction_amount,
            'status' => $request->query('status'),   // approved / pending / rejected
            'payment_id' => $request->query('payment_id'),
            'preference_id' => $request->query('preference_id'),
            'date_approved' => $request->query('status') === 'approved' ? $startDate : null,
        ]);

        if (!empty($payment->additional_info->items)) {
            foreach ($payment->additional_info->items as $mpItem) {
                $item = $order->items()->find($mpItem->id);
                if ($item) {
                    $item->update([
                        'unit_price' => $mpItem->unit_price
                    ]);
                }
            }
        }


       return view('user.payment.failure');
    }

    public function pending(Request $request)
    {
        $reference = $request->query('external_reference');
        $paymentId = $request->query('payment_id');
        $orderId = (int) str_replace('ORDEN_', '', $reference);

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'No existe la orden');
        }

        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        // Obtengo los datos del pago con la API de Mercado Pago
        $paymentClient = new PaymentClient();
        $payment = $paymentClient->get($paymentId);

        //dd($payment);
        $startDate = Carbon::parse($payment->date_approved)->startOfDay();

        $order->update([
            'total' => $payment->transaction_amount,
            'status' => $request->query('status'),   // approved / pending / rejected
            'payment_id' => $request->query('payment_id'),
            'preference_id' => $request->query('preference_id'),
            'date_approved' => $request->query('status') === 'approved' ? $startDate : null,
        ]);

        if (!empty($payment->additional_info->items)) {
            foreach ($payment->additional_info->items as $mpItem) {
                $item = $order->items()->find($mpItem->id);
                if ($item) {
                    $item->update([
                        'unit_price' => $mpItem->unit_price
                    ]);
                }
            }
        }
        return view('user.payment.failure');
    }


}
