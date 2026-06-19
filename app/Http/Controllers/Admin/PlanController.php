<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $plans = Plan::with('categories')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::orderBy('name')->get();
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedPlans = $request->validate([
            'title' => 'required|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'duration' => 'required|string|in:unico,mensual,anual',
            'price' => 'required|numeric|min:0',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:300|dimensions:max_width=620,max_height=413',
            'excerpt' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:5000',
        ], [
            'title.required' => 'El título es obligatorio.',
            'categories.required' => 'Debe seleccionar al menos una categoría.',
            'categories.*.exists' => 'La categoría seleccionada no es válida.',
            'duration.required' => 'La duración es obligatoria.',
            'duration.in' => 'La duración seleccionada no es válida.',
            'price.required' => 'La tarifa es obligatoria.',
            'status' => 'El estado es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.max' => 'La imagen no debe superar los 300 KB.',
            'image.mimes' => 'Solo se permiten archivos: jpeg, png, jpg, gif, webp.',
            'image.dimensions' => 'La imagen no debe superar los 620 px de ancho ni los 413 px de alto.',
            'excerpt.string' => 'El extracto debe ser un texto válido.',
            'excerpt.max' => 'El extracto no puede superar los 1000 caracteres.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no puede superar los 5000 caracteres.',
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('uploads/plans');
            $validatedPlans['image'] = basename($path);
        }

        $validatedPlans['status'] = $request->has('status') ? 1 : 0;

        $plan = Plan::create($validatedPlans);

        $plan->categories()->sync($request->input('categories',[]));

        return redirect()->route('admin.plans.index')->with('success', 'El plan fue creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
        $plan->load('categories');
        return view('admin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
        $categories = Category::orderBy('name')->get();
        $plan->load('categories');
        return view('admin.plans.edit', compact('plan', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        //
        $validatedPlans = $request->validate([
            'title' => 'required|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'duration' => 'required|string|in:unico,mensual,anual',
            'price' => 'required|numeric|min:0',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:300|dimensions:max_width=620,max_height=413',
            'excerpt' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:5000',
        ], [
            'title.required' => 'El título es obligatorio.',
            'duration.required' => 'La duración es obligatoria.',
            'duration.in' => 'La duración seleccionada no es válida.',
            'price.required' => 'La tarifa es obligatoria.',
            'status' => 'El estado es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.max' => 'La imagen no debe superar los 300 KB.',
            'image.mimes' => 'Solo se permiten archivos: jpeg, png, jpg, gif, webp.',
            'image.dimensions' => 'La imagen no debe superar los 620 px de ancho ni los 413 px de alto.',
            'excerpt.string' => 'El extracto debe ser un texto válido.',
            'excerpt.max' => 'El extracto no puede superar los 1000 caracteres.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no puede superar los 5000 caracteres.',
        ]);

        if($request->hasFile('image')){
            if ($plan->image && Storage::exists('uploads/plans/' . $plan->image)) {
                Storage::delete('uploads/plans/' . $plan->image);
            }

            $path = $request->file('image')->store('uploads/plans');
            $validatedPlans['image'] = basename($path);
        }

        $validatedPlans['status'] = $request->has('status') ? 1 : 0;

        $plan->update($validatedPlans);

        $plan->categories()->sync($request->input('categories',[]));

        return redirect()->route('admin.plans.index')->with('success', 'El plan fue actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
        $plan->categories()->detach();
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'El plan fue eliminado exitosamente.');
    }
}
