<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create(){
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('category.index')->with('error', 'Solo los administradores pueden crear categorias');
        }
        return view('category.create');
    }

    public function store(CategoryRequest $request){

        if (auth()->user()->role !== 'admin') {
            return redirect()->route('category.index')->with('error', 'Solo los administradores pueden crear categorias');
        }

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            Category::create($validated);
            return redirect()->route('category.index')->with('status', 'Categoria creada');
        }else{
            Category::create($request->validated());
            return redirect()->route('category.index')->with('status', 'Categoria creada');
        }

    }

    public function show(Category $category){
        $products = Product::with('category')->where('category_id', $category->id)->get();
        return view('category.show', compact('category','products'));
    }
    public function destroy(Category $category){
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('category.index')->with('error', 'Solo los administradores pueden eliminar categorias');
        }
        $category->delete();
        return redirect()->route('category.index')->with('status', 'Categoria eliminada');
    }

    public function edit(Category $category){
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('category.index')->with('error', 'Solo los administradores pueden editar categorias');
        }
        return view('category.edit', compact('category'));
    }
    public function update(CategoryRequest $request, Category $category){

        if (auth()->user()->role !== 'admin') {
            return redirect()->route('category.index')->with('error', 'Solo los administradores pueden editar categorias');
        }

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            $category->update($validated);
            return redirect()->route('category.show',$category)->with('status', 'Categoria Actualizada');
        }else{
        $category->update($request->validated());
        return redirect()->route('category.show',$category)->with('status', 'Categoria Actualizada');
        }
    }
}
