<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::with('plans')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedCategory = $request->validate([
            'code' => 'required|string|max:5|unique:categories,code',
            'name' => 'required|string|max:20',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'El código ya existe.',
            'code.max' => 'El código no puede superar los 5 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 20 caracteres.',
        ]);

        Category::create($validatedCategory);

        return redirect()->route('admin.categories.index')->with('success', 'La categoría fue creada exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validatedCategory = $request->validate([
            'code' => 'required|string|max:5|unique:categories,code,' . $category->id,
            'name' => 'required|string|max:20',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'El código ya existe.',
            'code.max' => 'El código no puede superar los 5 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 20 caracteres.',
        ]);

        $category->update($validatedCategory);

        return redirect()->route('admin.categories.index')->with('success', 'La categoría fue actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'La categoría fue eliminada exitosamente.');
    }
}
