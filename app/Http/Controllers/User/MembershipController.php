<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;


class MembershipController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $totalPrice = $currentUser->plans->sum(function($plan) { return $plan->price;});

        $expiredPlanIds = $currentUser->plans
        ->filter(fn ($plan) => !$plan->pivot->is_valid_now)
        ->pluck('id')
        ->toArray();
        $hasPendingOrderForExpiredPlans = false;

        $hasPendingOrderForExpiredPlans = $currentUser->orders()
        ->where('status', 'pending')
        ->whereHas('items', function ($q) use ($expiredPlanIds) {
            $q->whereIn('plan_id', $expiredPlanIds);
        })
        ->exists();

        if (!empty($expiredPlanIds)) {
            $hasPendingOrderForExpiredPlans = $currentUser->orders()
                ->where('status', 'pending')
                ->whereHas('items', fn ($q) => $q->whereIn('plan_id', $expiredPlanIds))
                ->exists();
        }

        return view('user.membership.index', compact('currentUser','totalPrice', 'hasPendingOrderForExpiredPlans'));
    }

    public function create()
    {

        $user = Auth::user();

        // Verifico si ya tiene planes
        $hasPlans = $user->plans()->exists();

        if ($hasPlans) {
            // Si ya tiene planes, lo reedirigo a editar
            return redirect()->route('user.membership.edit');
        }

        // Planes activos con las categorias ordenado según la duración
        $plansActive = Plan::where('status', 1)
            ->with('categories')
            ->orderByRaw("FIELD(duration, 'unico', 'mensual', 'anual')")
            ->get();

        // Planes con solo una categoría
        $singleCategoryPlans = $plansActive->filter(function($plan) {
            return $plan->categories->count() === 1;
        });

        // Separo planes con varias categorías
        $multiCategoryPlans = $plansActive->filter(function($plan) {
            return $plan->categories->count() > 1;
        });

        $plansGrouped = $singleCategoryPlans
            ->groupBy(fn($plan) => optional($plan->categories->first())->name ?? 'Sin categoría');


        return view('user.membership.create', compact('plansActive', 'singleCategoryPlans', 'multiCategoryPlans', 'plansGrouped'));

    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'plans' => ['nullable', 'array'],
            'plans.*' => ['integer', 'exists:plans,id']
        ]);

        $user = Auth::user();

        if (empty($validated['plans'])) {
            return redirect()->route('user.dashboard')->with('success', 'No tenés membresía vigente.');
        }

        // Solo para asegurme de no duplicar planes que ya tenga
        $existingPlanIds = $user->plans()->pluck('plans.id')->toArray();
        $newPlans = array_diff($validated['plans'], $existingPlanIds);

        if (!empty($newPlans)) {
            // Guardo solo los planes nuevo sin duplicar
            $user->plans()->syncWithoutDetaching($newPlans);

        }

        // Creo la orden con los planes inactivos
        $inactivePlans = $user->plans->where('pivot.is_active', false)->unique('id');
        if ($inactivePlans->isEmpty()) {
            return redirect()->route('user.dashboard')->with('success', 'No tenés cuotas pendientes de pago.');
        }

        $order = Order::create([
            'user_id'   => $user->id,
            'total'     => null,
            'status'    => 'pending', // pendiente de pago
            'payment_id' => null,
            'preference_id' => null,
            'date_approved' => null
        ]);

        foreach ($inactivePlans as $plan) {
            OrderItem::create([
                'order_id'   => $order->id,
                'plan_id'    => $plan->id,
                'title'      => $plan->title,
                'description'=> $plan->description ?? '',
                'quantity'   => 1,
                'unit_price' => null,
            ]);
        }

        return redirect()->route('user.payment.index');
    }

    public function edit()
    {
        $currentUser = Auth::user();
        $currentUser = User::with('plans')->find($currentUser->id);

        // Planes activos con las categorias ordenado segun la duración
        $plansActive = Plan::where('status', 1)
            ->with('categories')
            ->orderByRaw("FIELD(duration, 'unico', 'mensual', 'anual')")
            ->get();

        // Planes con solo una categoría
        $singleCategoryPlans = $plansActive->filter(function($plan) {
            return $plan->categories->count() === 1;
        });

        // Separar planes con varias categorías
        $multiCategoryPlans = $plansActive->filter(function($plan) {
            return $plan->categories->count() > 1;
        });

        $plansGrouped = $singleCategoryPlans->groupBy(fn($plan) => optional($plan->categories->first())->name ?? 'Sin categoría');

        // Abono total de los planes actuales
        $totalPrice = $currentUser->plans->sum('price');

        // Planes por abonar
        $inactivePlans = $currentUser->plans->where('pivot.is_active', 0);

        return view('user.membership.edit', compact('currentUser', 'plansActive', 'singleCategoryPlans', 'multiCategoryPlans', 'plansGrouped', 'totalPrice', 'inactivePlans'));
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'plans' => ['nullable', 'array'],
            'plans.*' => ['integer', 'exists:plans,id']
        ]);

        $currentUser = Auth::user();

        $requestPlanIds = $validated['plans'] ?? [];

        if (empty($requestPlanIds)) {
            $currentUser->orders()->where('status', 'pending')->delete();
            $currentUser->cancelPlans($currentUser->plans()->pluck('plans.id')->toArray());
            return redirect()->route('user.dashboard')->with('success', 'No tenés membresía vigente.');
        }

        // Traigo los planes que tenga el usuario
        $existingPlanIds = $currentUser->plans()->withPivot('is_active', 'end_date', 'start_date')->get();

        // Elimino los planes que no estan en el request porque entiendo que cancela el plan
        $plansToRemove = $existingPlanIds->pluck('id')->diff($requestPlanIds)->toArray();
        if($plansToRemove){
            $currentUser->cancelPlans($plansToRemove);
        }

        // Pongo en activo los planes que trae en el request que estan como inactivos pero que estan vigentes
        $plansToActivate = $existingPlanIds->filter(function($plan) use ($requestPlanIds) {
            return in_array($plan->id, $requestPlanIds)
                && !$plan->pivot->is_active
                && $plan->pivot->is_valid_now;
        });
        foreach ($plansToActivate as $plan) {
            $currentUser->plans()->updateExistingPivot($plan->id, ['is_active' => true]);
        }

        // Agrego los nuevos con is_active false
        $newPlans = array_diff($requestPlanIds, $existingPlanIds->pluck('id')->toArray());
        if (!empty($newPlans)) {
            $currentUser->plans()->attach($newPlans);
        }

        // Obtengo los planes inactivos para generar la orden pero ademas obtengo los que estan activos vencidos para renovar
        $inactivePlans = $currentUser->plans
        ->whereIn('id', $requestPlanIds) // solo los plan_ids solicitados
        ->filter(fn($plan) => !$plan->pivot->is_active || ($plan->pivot->is_active && !$plan->pivot->is_valid_now))
        ->unique('id');

        if ($inactivePlans->isEmpty()) {
            return redirect()->route('user.dashboard')->with('success', 'No tenés cuotas pendientes de pago.');
        }

        // Veo si tiene ordenes pendientes
        $order = $currentUser->orders()->where('status', 'pending')->first();

        // Si no la tiene la creo
        if (!$order) {
            $order = Order::create([
                'user_id'   => $currentUser->id,
                'total'     => null,
                'status'    => 'pending', // pendiente de pago
                'payment_id' => null,
                'preference_id' => null,
                'date_approved' => null
            ]);
        }

        // Los items de la orden
        $existingItemPlanIds = $order->items()->pluck('plan_id')->toArray();

        // Elimino los items que no van
        $itemsToRemove = array_diff($existingItemPlanIds, $requestPlanIds);
        if (!empty($itemsToRemove)) {
            $order->items()->whereIn('plan_id', $itemsToRemove)->delete();
        }

        // Agrego los items nuevos que no estan
        $itemsToAdd = array_diff($requestPlanIds, $existingItemPlanIds);
        foreach ($inactivePlans->whereIn('id', $itemsToAdd) as $plan) {
            OrderItem::create([
                'order_id' => $order->id,
                'plan_id' => $plan->id,
                'title' => $plan->title,
                'description' => $plan->description ?? '',
                'quantity' => 1,
                'unit_price' => null,
            ]);
        }

        return redirect()->route('user.payment.index')->with('success', 'Membresía actualizada correctamente. Recordá tener la cuota al día para tener la membresía vigente.');

    }

    public function cancel(Request $request)
    {
        $validated = $request->validate([
            'plans' => ['nullable', 'array'],
            'plans.*' => ['integer', 'exists:plans,id']
        ]);

        $currentUser = Auth::user();

        $plans = $validated['plans'] ?? [];

        $currentUser->cancelPlans($plans);

        return redirect()->route('user.membership.index')->with('success', 'Plan cancelado correctamente.');

    }


    public function destroy()
    {
        $user = Auth::user();
        $user->orders()->where('status', 'pending')->delete();

        //$user->plans()->detach();
        $user->plans()->updateExistingPivot(
            $user->plans->pluck('id')->toArray(),
            ['is_active' => false]
        );
        return redirect()->route('user.dashboard')->with('success', 'Se canceló exitosamente tu membresía. Esperamos verte pronto!');
    }
}
